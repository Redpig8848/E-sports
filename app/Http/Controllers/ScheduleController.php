<?php

namespace App\Http\Controllers;

use App\Match;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Symfony\Component\DomCrawler\Crawler;

class ScheduleController extends Controller
{
    //


    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 3;  // 同时并发抓取

    protected $startUrl = 'https://www.autotimes.com.cn/news/1.html';

    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount) {
            return;
        }
    }


    public function index()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $timestamp = mktime(0, 0, 0, 1, 1, date('Y'));

        $stime = strtotime(date('Y-m-d', $timestamp));

        $timestamp = mktime(0, 0, 0, 12, 31, date('Y'));

        $etime = strtotime(date('Y-m-d', $timestamp));
        while ($stime <= $etime) {
            $this->url[] = 'https://www.500bf.com/index/index/schedule?date=' . date('Y-m-d', $stime) . '&type=0';
            $stime = $stime + 86400;
        }
        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->getAsync($uri, ['verify' => false]);
                };
            }
        };

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) {
                echo '爬取' . $this->url[$index];
                echo '<br>';
                if(ob_get_level()>0)
                    ob_flush();
                flush();
                try {
//                    dd($response->getBody()->getContents());
                    $http = $response->getBody()->getContents();
//                    $http = iconv('gbk', 'UTF-8', $response->getBody()->getContents());
                } catch (\Exception $e) {
                    echo '没有找到数据';
                }
                if (!empty($http)) {
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($http);
                    $arr = $crawler->filter('body > div > div.schedule-wrapper.default-continer > div.match-panel > div > div > div')->each(function ($node, $i) use ($http) {
                        $data['gameimg'] = 'https://www.500bf.com' . $node->filter('img')->attr('src');

                        // 所属游戏
                        if (strpos($data['gameimg'], 'dota') !== false) {
                            $data['gametype'] = 'DOTA2';
                        } elseif (strpos($data['gameimg'], 'csgo') !== false) {
                            $data['gametype'] = 'CS:GO';
                        } elseif (strpos($data['gameimg'], 'lol') !== false) {
                            $data['gametype'] = '英雄联盟';
                        } elseif (strpos($data['gameimg'], 'kog') !== false) {
                            $data['gametype'] = '王者荣耀';
                        } else {
                            $data['gametype'] = '英雄联盟';
                        }

                        $client_img = new Client(['verify' => false]);
                        $filename = substr($data['gameimg'],strrpos($data['gameimg'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try {
                                $client_img->get('https://www.500bf.com'.$data['gameimg'],['save_to' => public_path('static/'.$filename)]);
                                $data['gameimg'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $e){
                                $data['gameimg'] = '';
                            }
                        }else {
                            $data['gameimg'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['matchtime'] = $node->filter('p.match-item-time')->text();
                        $data['BO'] = $node->filter('p.match-item-bo')->text();
                        $data['team1'] = $node->filter('div.home-team > p')->text();
                        $data['team1img'] = $node->filter('div.home-team > img')->attr('src');

                        $filename = substr($data['team1img'],strrpos($data['team1img'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try{
                            $client_img->get($data['team1img'],['save_to' => public_path('static/'.$filename)]);
                            $data['team1img'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $e){
                                $data['team1img'] = '';
                            }
                        }else{
                            $data['team1img'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        try {
                            $data['score'] = $node->filter('p.match-item-score')->text();
                        } catch (\Exception $exception) {
                            $data['score'] = $node->filter('p.match-item-tag')->text();
                        }

                        $data['team2img'] = $node->filter('div.away-team > img')->attr('src');

                        $filename = substr($data['team2img'],strrpos($data['team2img'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try{
                            $client_img->get($data['team2img'],['save_to' => public_path('static/'.$filename)]);
                            $data['team2img'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $e){
                                $data['team2img'] = '';
                            }
                        }else{
                            $data['team2img'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['team2'] = $node->filter('div.away-team > p')->text();
                        $data['eventsimg'] = $node->filter('div.leagues > img')->attr('src');

                        $filename = substr($data['eventsimg'],strrpos($data['eventsimg'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try{
                            $client_img->get($data['eventsimg'],['save_to' => public_path('static/'.$filename)]);
                            $data['eventsimg'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $e){
                                $data['eventsimg'] = '';
                            }
                        }else{
                            $data['eventsimg'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['events'] = $node->filter('div.leagues > p')->text();
                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'],$data['gametype']);
                        if ($events_id) {
                            $data['eventsid'] = $events_id;
                        } else { // 赛事不存在，需新增
                            try {
                                $events_onclick = $node->filter('div.leagues')->attr('onclick');
                                $events_link = substr($events_onclick, strpos($events_onclick, 'hrefClicked(\'') + 13);
                                $events_link = substr($events_link, 0, strpos($events_link, '\')'));
                                $events_client = new Client();
                                $events_response = $events_client->get('https://www.500bf.com' . $events_link, ['verify' => false]);
                                $events_request = $events_response->getBody()->getContents();
                                $events_crawler = new Crawler();
                                $events_crawler->addHtmlContent($events_request);
                                $events['match'] = $data['events'];
                                $events['matchimg'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-logo > img')->attr('src');
                                $filename = substr($events['matchimg'],strrpos($events['matchimg'],'/')+1);
                                if (!file_exists(public_path('static/'.$filename))){
                                    try {
                                        $client_img->get($events['matchimg'],['save_to' => public_path('static/'.$filename)]);
                                        $events['matchimg'] = 'http://45.157.91.154/static/'.$filename;
                                    }catch (\Exception $exception){
                                        $events['matchimg'] = '';
                                    }

                                }else{
                                    $events['matchimg'] = 'http://45.157.91.154/static/'.$filename;
                                }
                                $events['matchtime'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.match-time > div > p:nth-child(2)')->text();
                                $events['teams'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.teamIds > div > p:nth-child(2)')->text();
                                $events['money'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.prize > div > p:nth-child(2)')->text();
                                $events['venue'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.address > div > p:nth-child(2)')->text();
                                $events['organizers'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.organizer > div > p:nth-child(2)')->text();
                            } catch (\Exception $exception) {
                                $events['match'] = $data['events'];
                                $events['matchimg'] = '该赛事内容不存在';
                                $events['matchtime'] = '';
                                $events['teams'] = '';
                                $events['money'] = '';
                                $events['venue'] = '';
                                $events['organizers'] = '';
                            }

                            $events['game'] = $data['gametype'];

                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在'){
                                $matchspider = new MatchSpiderController();
                                $matchspider->AllMatch($events);
                            }
                        }


//                        dd($data);
                        return $data;
                    });
//                    dd($arr);
                    $bool = DB::table('allschedule')->insert($arr);
                    echo $bool;
                    echo '<br>';
                    $this->countedAndCheckEnded();
                }
            },
            'rejected' => function ($reason, $index) {
//                    log('test',"rejected" );
//                    log('test',"rejected reason: " . $reason );
                $this->countedAndCheckEnded();
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();

    }

    public function today()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $this->url[] = 'https://www.500bf.com/index/index/schedule?date=' . date('Y-m-d') . '&type=0';

        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->getAsync($uri, ['verify' => false]);
                };
            }
        };

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) {
                echo '爬取' . $this->url[$index];
                echo '<br>';
                if(ob_get_level()>0)
                    ob_flush();
                flush();
                try {
//                    dd($response->getBody()->getContents());
                    $http = $response->getBody()->getContents();
//                    $http = iconv('gbk', 'UTF-8', $response->getBody()->getContents());
                } catch (\Exception $e) {
                    echo '没有找到数据';
                }
                if (!empty($http)) {
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($http);
                    $arr = $crawler->filter('body > div > div.schedule-wrapper.default-continer > div.match-panel > div > div > div')->each(function ($node, $i) use ($http) {
                        $data['gameimg'] = 'https://www.500bf.com' . $node->filter('img')->attr('src');

                        // 所属游戏
                        if (strpos($data['gameimg'], 'dota') !== false) {
                            $data['gametype'] = 'DOTA2';
                        } elseif (strpos($data['gameimg'], 'csgo') !== false) {
                            $data['gametype'] = 'CS:GO';
                        } elseif (strpos($data['gameimg'], 'lol') !== false) {
                            $data['gametype'] = '英雄联盟';
                        } elseif (strpos($data['gameimg'], 'kog') !== false) {
                            $data['gametype'] = '王者荣耀';
                        } else {
                            $data['gametype'] = '英雄联盟';
                        }

                        $client_img = new Client(['verify' => false]);
                        $filename = substr($data['gameimg'],strrpos($data['gameimg'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try {
                                $client_img->get('https://www.500bf.com'.$data['gameimg'],['save_to' => public_path('static/'.$filename)]);
                                $data['gameimg'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $exception){
                                $data['gameimg'] = '';
                            }

                        }else{
                            $data['gameimg'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['matchtime'] = $node->filter('p.match-item-time')->text();
                        $data['BO'] = $node->filter('p.match-item-bo')->text();
                        $data['team1'] = $node->filter('div.home-team > p')->text();
                        $data['team1img'] = $node->filter('div.home-team > img')->attr('src');

                        $filename = substr($data['team1img'],strrpos($data['team1img'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try {
                                $client_img->get($data['team1img'],['save_to' => public_path('static/'.$filename)]);
                                $data['team1img'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $exception){
                                $data['team1img'] = '';
                            }

                        }else{
                            $data['team1img'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        try {
                            $data['score'] = $node->filter('p.match-item-score')->text();
                        } catch (\Exception $exception) {
                            $data['score'] = $node->filter('p.match-item-tag')->text();
                        }

                        $data['team2img'] = $node->filter('div.away-team > img')->attr('src');

                        $filename = substr($data['team2img'],strrpos($data['team2img'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try {
                                $client_img->get($data['team2img'],['save_to' => public_path('static/'.$filename)]);
                                $data['team2img'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $exception){
                                $data['team2img'] = '';
                            }

                        }else{
                            $data['team2img'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['team2'] = $node->filter('div.away-team > p')->text();
                        $data['eventsimg'] = $node->filter('div.leagues > img')->attr('src');

                        $filename = substr($data['eventsimg'],strrpos($data['eventsimg'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try {
                                $client_img->get($data['eventsimg'],['save_to' => public_path('static/'.$filename)]);
                                $data['eventsimg'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $exception){
                                $data['eventsimg'] = '';
                            }

                        }else{
                            $data['eventsimg'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['events'] = $node->filter('div.leagues > p')->text();
                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'],$data['gametype']);
                        if ($events_id) {
                            $data['eventsid'] = $events_id;
                        } else { // 赛事不存在，需新增
                            try {
                                $events_onclick = $node->filter('div.leagues')->attr('onclick');
                                $events_link = substr($events_onclick, strpos($events_onclick, 'hrefClicked(\'') + 13);
                                $events_link = substr($events_link, 0, strpos($events_link, '\')'));
                                $events_client = new Client();
                                $events_response = $events_client->get('https://www.500bf.com' . $events_link, ['verify' => false]);
                                $events_request = $events_response->getBody()->getContents();
                                $events_crawler = new Crawler();
                                $events_crawler->addHtmlContent($events_request);
                                $events['match'] = $data['events'];
                                $events['matchimg'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-logo > img')->attr('src');
                                $filename = substr($events['matchimg'],strrpos($events['matchimg'],'/')+1);
                                if (!file_exists(public_path('static/'.$filename))){
                                    try {
                                        $client_img->get($events['matchimg'],['save_to' => public_path('static/'.$filename)]);
                                        $events['matchimg'] = 'http://45.157.91.154/static/'.$filename;
                                    }catch (\Exception $exception){
                                        $events['matchimg'] = '';
                                    }

                                }else{
                                    $events['matchimg'] = 'http://45.157.91.154/static/'.$filename;
                                }
                                $events['matchtime'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.match-time > div > p:nth-child(2)')->text();
                                $events['teams'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.teamIds > div > p:nth-child(2)')->text();
                                $events['money'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.prize > div > p:nth-child(2)')->text();
                                $events['venue'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.address > div > p:nth-child(2)')->text();
                                $events['organizers'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.organizer > div > p:nth-child(2)')->text();
                            } catch (\Exception $exception) {
                                $events['match'] = $data['events'];
                                $events['matchimg'] = '该赛事内容不存在';
                                $events['matchtime'] = '';
                                $events['teams'] = '';
                                $events['money'] = '';
                                $events['venue'] = '';
                                $events['organizers'] = '';
                            }

                            $events['game'] = $data['gametype'];

                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在'){
                                $matchspider = new MatchSpiderController();
                                $matchspider->AllMatch($events);
                            }
                        }


//                        dd($data);
                        return $data;
                    });
//                    dd($arr);
                    foreach ($arr as $item) {
                        $id = DB::table('allschedule')->where([
                            ['matchtime', '=', $item['matchtime']],
                            ['team1', '=', $item['team1']],
                            ['events', '=', $item['events']],
                        ])->select('id')->get()->toArray();
                        if ($id) {
                            DB::table('allschedule')->where('id', $id[0]->id)->update(['score' => $item['score']]);
                        } else {
                            DB::table('allschedule')->insert($item);
                        }
                    }

                    echo '<br>';
                    $this->countedAndCheckEnded();
                }
            },
            'rejected' => function ($reason, $index) {
//                    log('test',"rejected" );
//                    log('test',"rejected reason: " . $reason );
                $this->countedAndCheckEnded();
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();

    }


    public function after()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $timestamp = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        $stime = strtotime(date('Y-m-d', $timestamp))+86400;

//        $timestamp = mktime(0, 0, 0, 12, 31, date('Y'));

        $etime = strtotime(date('Y-m-d', $timestamp))+864000;
        while ($stime <= $etime) {
            $this->url[] = 'https://www.500bf.com/index/index/schedule?date=' . date('Y-m-d', $stime) . '&type=0';
            $stime = $stime + 86400;
        }
//        $this->url[] = 'https://www.500bf.com/index/index/schedule?date=' . date('Y-m-d') . '&type=0';

        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->getAsync($uri, ['verify' => false]);
                };
            }
        };

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) {
                echo '爬取' . $this->url[$index];
                echo '<br>';
                if(ob_get_level()>0)
                    ob_flush();
                flush();
                try {
//                    dd($response->getBody()->getContents());
                    $http = $response->getBody()->getContents();
//                    $http = iconv('gbk', 'UTF-8', $response->getBody()->getContents());
                } catch (\Exception $e) {
                    echo '没有找到数据';
                }
                if (!empty($http)) {
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($http);
                    $arr = $crawler->filter('body > div > div.schedule-wrapper.default-continer > div.match-panel > div > div > div')->each(function ($node, $i) use ($http) {
                        $data['gameimg'] = 'https://www.500bf.com' . $node->filter('img')->attr('src');

                        // 所属游戏
                        if (strpos($data['gameimg'], 'dota') !== false) {
                            $data['gametype'] = 'DOTA2';
                        } elseif (strpos($data['gameimg'], 'csgo') !== false) {
                            $data['gametype'] = 'CS:GO';
                        } elseif (strpos($data['gameimg'], 'lol') !== false) {
                            $data['gametype'] = '英雄联盟';
                        } elseif (strpos($data['gameimg'], 'kog') !== false) {
                            $data['gametype'] = '王者荣耀';
                        } else {
                            $data['gametype'] = '英雄联盟';
                        }

                        $client_img = new Client(['verify' => false]);
                        $filename = substr($data['gameimg'],strrpos($data['gameimg'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try {
                                $client_img->get('https://www.500bf.com'.$data['gameimg'],['save_to' => public_path('static/'.$filename)]);
                                $data['gameimg'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $exception){
                                $data['gameimg'] = '';
                            }

                        }else{
                            $data['gameimg'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['matchtime'] = $node->filter('p.match-item-time')->text();
                        $data['BO'] = $node->filter('p.match-item-bo')->text();
                        $data['team1'] = $node->filter('div.home-team > p')->text();
                        $data['team1img'] = $node->filter('div.home-team > img')->attr('src');

                        $filename = substr($data['team1img'],strrpos($data['team1img'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try {
                                $client_img->get($data['team1img'],['save_to' => public_path('static/'.$filename)]);
                                $data['team1img'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $exception){
                                $data['team1img'] = '';
                            }

                        }else{
                            $data['team1img'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        try {
                            $data['score'] = $node->filter('p.match-item-score')->text();
                        } catch (\Exception $exception) {
                            $data['score'] = $node->filter('p.match-item-tag')->text();
                        }

                        $data['team2img'] = $node->filter('div.away-team > img')->attr('src');

                        $filename = substr($data['team2img'],strrpos($data['team2img'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try {
                                $client_img->get($data['team2img'],['save_to' => public_path('static/'.$filename)]);
                                $data['team2img'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $exception){
                                $data['team2img'] = '';
                            }

                        }else{
                            $data['team2img'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['team2'] = $node->filter('div.away-team > p')->text();
                        $data['eventsimg'] = $node->filter('div.leagues > img')->attr('src');

                        $filename = substr($data['eventsimg'],strrpos($data['eventsimg'],'/')+1);
                        if (!file_exists(public_path('static/'.$filename))){
                            try {
                                $client_img->get($data['eventsimg'],['save_to' => public_path('static/'.$filename)]);
                                $data['eventsimg'] = 'http://45.157.91.154/static/'.$filename;
                            }catch (\Exception $exception){
                                $data['eventsimg'] = '';
                            }

                        }else{
                            $data['eventsimg'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['events'] = $node->filter('div.leagues > p')->text();
                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'],$data['gametype']);
                        if ($events_id) {
                            $data['eventsid'] = $events_id;
                        } else { // 赛事不存在，需新增
                            try {
                                $events_onclick = $node->filter('div.leagues')->attr('onclick');
                                $events_link = substr($events_onclick, strpos($events_onclick, 'hrefClicked(\'') + 13);
                                $events_link = substr($events_link, 0, strpos($events_link, '\')'));
                                $events_client = new Client();
                                $events_response = $events_client->get('https://www.500bf.com' . $events_link, ['verify' => false]);
                                $events_request = $events_response->getBody()->getContents();
                                $events_crawler = new Crawler();
                                $events_crawler->addHtmlContent($events_request);
                                $events['match'] = $data['events'];
                                $events['matchimg'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-logo > img')->attr('src');
                                $filename = substr($events['matchimg'],strrpos($events['matchimg'],'/')+1);
                                if (!file_exists(public_path('static/'.$filename))){
                                    try {
                                        $client_img->get($events['matchimg'],['save_to' => public_path('static/'.$filename)]);
                                        $events['matchimg'] = 'http://45.157.91.154/static/'.$filename;
                                    }catch (\Exception $exception){
                                        $events['matchimg'] = '';
                                    }

                                }else{
                                    $events['matchimg'] = 'http://45.157.91.154/static/'.$filename;
                                }

                                $events['matchtime'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.match-time > div > p:nth-child(2)')->text();
                                $events['teams'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.teamIds > div > p:nth-child(2)')->text();
                                $events['money'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.prize > div > p:nth-child(2)')->text();
                                $events['venue'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.address > div > p:nth-child(2)')->text();
                                $events['organizers'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.organizer > div > p:nth-child(2)')->text();
                            } catch (\Exception $exception) {
                                $events['match'] = $data['events'];
                                $events['matchimg'] = '该赛事内容不存在';
                                $events['matchtime'] = '';
                                $events['teams'] = '';
                                $events['money'] = '';
                                $events['venue'] = '';
                                $events['organizers'] = '';
                            }

                            $events['game'] = $data['gametype'];

                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在'){
                                $matchspider = new MatchSpiderController();
                                $matchspider->AllMatch($events);
                            }
                        }


//                        dd($data);
                        return $data;
                    });
//                    dd($arr);
                    foreach ($arr as $item) {
                        $id = DB::table('allschedule')->where([
                            ['matchtime', '=', $item['matchtime']],
                            ['team1', '=', $item['team1']],
                            ['events', '=', $item['events']],
                        ])->select('id')->get()->toArray();
                        if ($id) {
                            DB::table('allschedule')->where('id', $id[0]->id)->update(['score' => $item['score']]);
                        } else {
                            DB::table('allschedule')->insert($item);
                        }
                    }

                    echo '<br>';
                    $this->countedAndCheckEnded();
                }
            },
            'rejected' => function ($reason, $index) {
//                    log('test',"rejected" );
//                    log('test',"rejected reason: " . $reason );
                $this->countedAndCheckEnded();
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
    }
}
