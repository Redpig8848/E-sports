<?php

namespace App\Http\Controllers;

use App\Content;
use App\Match;
use App\Title;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;
use PhpParser\Node\Expr\Empty_;
use Symfony\Component\DomCrawler\Crawler;
use function foo\func;
use function GuzzleHttp\Psr7\str;

class HomeSpiderController extends Controller
{
    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 300;  // 同时并发抓取

    protected $startUrl = 'https://www.autotimes.com.cn/news/1.html';

    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount) {
            return;
        }
    }


    // 首页正在进行全部游戏  （完成）
    public function index()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        for ($i = 1; $i < 2; $i++) {
            $this->url[] = 'https://www.500bf.com/';
        }
        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->get($uri, ['verify' => false]);
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
                    $arr = $crawler->filter('#index_living > div > div')->each(function ($node, $i) use ($http) {
                        $data['eventsimg'] = $node->filter('div > div.header > div.item-league-panel > img')->attr('src');
                        $data['events'] = $node->filter('div > div.header > div.item-league-panel > p')->text();

                        $tema1img = $node->filter('div > div:nth-child(3) > div.tag-1 > img')->attr('src');
                        $tema2img = $node->filter('div > div:nth-child(4) > div.tag-1 > img')->attr('src');
                        $find_request = false;
                        // 所属游戏
                        if (strpos($data['eventsimg'], 'dota') !== false || strpos($tema1img, 'dota') !== false ||
                            strpos($tema2img, 'dota') !== false) {
                            $data['game'] = 'DOTA2';
                        } elseif (strpos($data['eventsimg'], 'csgo') !== false || strpos($tema1img, 'csgo') !== false ||
                            strpos($tema2img, 'csgo') !== false) {
                            $data['game'] = 'CS:GO';
                        } elseif (strpos($data['eventsimg'], 'lol') !== false || strpos($tema1img, 'lol') !== false ||
                            strpos($tema2img, 'lol') !== false) {
                            $data['game'] = '英雄联盟';
                        } elseif (strpos($data['eventsimg'], 'kog') !== false || strpos($tema1img, 'kog') !== false ||
                            strpos($tema2img, 'kog') !== false) {
                            $data['game'] = '王者荣耀';
                        } else {
                            $find_onclick = $node->filter('div > div.header > div')->attr('onclick');
                            $find_link = substr($find_onclick, strpos($find_onclick, 'hrefClicked(\'') + 13);
                            $find_link = substr($find_link, 0, strpos($find_link, '\')'));
                            $find_client = new Client();
                            $find_response = $find_client->get('https://www.500bf.com' . $find_link, ['verify' => false]);
                            $find_request = $find_response->getBody()->getContents();

                            if (strpos($find_request,'/dota/team') !== false){
                                $data['game'] = 'DOTA2';
                            } elseif (strpos($find_request,'/csgo/team')) {
                                $data['game'] = 'CS:GO';
                            } elseif (strpos($find_request,'/lol/team')) {
                                $data['game'] = '英雄联盟';
                            } elseif (strpos($find_request,'/kog/team')) {
                                $data['game'] = '王者荣耀';
                            }


                        }

                        $client_img = new Client(['verify' => false]);
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


                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'],$data['game']);
                        if ($events_id) {
                            $data['eventsid'] = $events_id;
                        } else { // 赛事不存在，需新增
                            if ($find_request){
                                $events_crawler = new Crawler();
                                $events_crawler->addHtmlContent($find_request);
                            } else {
                                $events_onclick = $node->filter('div > div.header > div')->attr('onclick');
                                $events_link = substr($events_onclick, strpos($events_onclick, 'hrefClicked(\'') + 13);
                                $events_link = substr($events_link, 0, strpos($events_link, '\')'));
                                $events_client = new Client();
                                $events_response = $events_client->get('https://www.500bf.com' . $events_link, ['verify' => false]);
                                $events_request = $events_response->getBody()->getContents();
                                $events_crawler = new Crawler();
                                $events_crawler->addHtmlContent($events_request);
                            }

                            $events['match'] = $data['events'];
                            $events['matchimg'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-logo > img')->attr('src');
                            $filename = substr($events['matchimg'],strrpos($events['matchimg'],'/')+1);
                            if (!file_exists(public_path('static/'.$filename))){
                                try {
                                    $client_img->get($events['matchimg'],['save_to' => public_path('static/'.$filename)]);
                                    $events['matchimg'] = 'http://45.157.91.154/static/'.$filename;
                                } catch (\Exception $exception){
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

                            $events['game'] = $data['game'];

                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在'){
                                $matchspider = new MatchSpiderController();
                                $matchspider->AllMatch($events);
                            }
                        }


                        $arr = array();
                        // 开始处理直播地址
                        $tv_arr = $node->filter('div > div.header > div.videos-panel > ul > li')->each(function ($node2, $i) use ($arr) {
                            $arr = array_add($arr, $node2->filter('a > span')->text(), 'https://www.500bf.com' . $node2->filter('a')->attr('href'));
                            return $arr;
                        });
                        $data['tv'] = '';
                        if (!empty($tv_arr)) {
                            foreach ($tv_arr as $value) {
                                $tv_client = new Client();
                                $tv_response = $tv_client->get(current($value), ['verify' => false]);
                                $tv_http = $tv_response->getBody()->getContents();
                                if (strpos($tv_http, '500电竞比分网') !== false) {
                                    $iframe = substr($tv_http, strpos($tv_http, "class=\"live-iframe\"") + 20);
                                    $iframe = substr($iframe, 0, strpos($iframe, '">'));
                                    $data['tv'] = $data['tv'] . key($value) . "=>" . substr($iframe, strpos($iframe, 'http')) . "|";
                                } else {
                                    $data['tv'] = $data['tv'] . key($value) . "=>" . current($value) . "|";
                                }
//                                echo current($value);
                            }
                        }

                        $data['now'] = $node->filter('div > div.item-row-title > div.tag-1 > p')->text();
                        $data['BO'] = $node->filter('div > div.item-row-title > div.tag-2 > p')->text();
                        try {
                            $data['pooreconomy'] = $node->filter('div > div.item-row-title > div.tag-3 > p')->text();
                        } catch (\Exception $exception) {
                            $data['pooreconomy'] = '0K';
                        }
                        $data['team1img'] = $tema1img;

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

                        $data['team1'] = $node->filter('div > div:nth-child(3) > div.tag-1 > p')->text();
                        $data['team1winnum'] = (integer)$node->filter('div > div:nth-child(3) > div.tag-2 > p.score')->text();
                        $data['team1killnum'] = (integer)$node->filter('div > div:nth-child(3) > div.tag-2 > p.kill')->text();


                        // 开始处理特殊图标   图标可能为空  可能为一个或多个
                        $data['team1special'] = $node->filter('div > div:nth-child(3) > div.tag-2 > div > div')->each(function ($node3, $i) {
                            return 'https://www.500bf.com' . $node3->filter('img')->attr('src');
                        });
                        if (is_array($data['team1special']))
                            $data['team1special'] = implode("|", $data['team1special']);

//                        if (!Empty($team1special_var)){
//                            $data['team1special'] = $team1special_var;
//                        } else {
//                            $data['team1special'] = '';
//                        }
                        $data['team2img'] = $tema2img;

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

                        $data['team2'] = $node->filter('div > div:nth-child(4) > div.tag-1 > p')->text();
                        $data['team2winnum'] = (integer)$node->filter('div > div:nth-child(4) > div.tag-2 > p.score')->text();
                        $data['team2killnum'] = (integer)$node->filter('div > div:nth-child(4) > div.tag-2 > p.kill')->text();

                        // 开始处理特殊图标   图标可能为空  可能为一个或多个
                        $data['team2special'] = $node->filter('div > div:nth-child(4) > div.tag-2 > div > div')->each(function ($node3, $i) {
                            return 'https://www.500bf.com' . $node3->filter('img')->attr('src');
                        });
                        if (is_array($data['team2special']))
                            $data['team2special'] = implode("|", $data['team2special']);
//                        dd($data);
                        return $data;
                    });
//                    dd($arr);
                    DB::table('allmatching')->truncate();
                    DB::table('allmatching')->insert($arr);
//                    echo $bool;
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


    // 首页全部游戏未开始  （已完成）
    public function allmatch()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        for ($i = 1; $i < 2; $i++) {
            $this->url[] = 'https://www.500bf.com/';
        }
        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->get($uri, ['verify' => false]);
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
                    $arr = $crawler->filter('body > div > div.home-wapper.default-continer > div > div.home-container > div.match-wrapper > div > div.container > div')->each(function ($node, $i) use ($http) {
                        $data['gameimg'] = $node->filter('img')->attr('src');



                        // 所属游戏
                        if (strpos($data['gameimg'], 'dota') !== false) {
                            $data['game'] = 'DOTA2';
                        } elseif (strpos($data['gameimg'], 'csgo') !== false) {
                            $data['game'] = 'CS:GO';
                        } elseif (strpos($data['gameimg'], 'lol') !== false) {
                            $data['game'] = '英雄联盟';
                        } elseif (strpos($data['gameimg'], 'kog') !== false) {
                            $data['game'] = '王者荣耀';
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


                        $data['time'] = $node->filter('p.match-item-time')->text();
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
                        $data['eventsimg'] = $node->filter('div.league > img')->attr('src');

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

                        $data['events'] = $node->filter('div.league > p')->text();

                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'],$data['game']);
                        if ($events_id) {
                            $data['eventsid'] = $events_id;
                        } else { // 赛事不存在，需新增
                            $events_onclick = $node->filter('div.league')->attr('onclick');
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

                            $events['game'] = $data['game'];

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
                    DB::table('allmatch')->truncate();
                    DB::table('allmatch')->insert($arr);


//                    $bool = DB::table('title')->insert($arr);
//                    echo $bool;
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



    // 比分  未开始
    public function scorenot()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        for ($i = 1; $i < 2; $i++) {
            $this->url[] = 'https://www.500bf.com/index/index/score?type=0&subtype=0';
        }
        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->get($uri, ['verify' => false]);
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
                    $arr = $crawler->filter('body > div.body > div.score-warpper.default-continer > div.score-list-panel > div.match-wait-panel-wrapper > div.container > div')->each(function ($node, $i) use ($http) {
                        $data['gameimg'] = 'https://www.500bf.com'.$node->filter('img')->attr('src');



                        // 所属游戏
                        if (strpos($data['gameimg'], 'dota') !== false) {
                            $data['game'] = 'DOTA2';
                        } elseif (strpos($data['gameimg'], 'csgo') !== false) {
                            $data['game'] = 'CS:GO';
                        } elseif (strpos($data['gameimg'], 'lol') !== false) {
                            $data['game'] = '英雄联盟';
                        } elseif (strpos($data['gameimg'], 'kog') !== false) {
                            $data['game'] = '王者荣耀';
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


                        $data['time'] = $node->filter('p.match-item-time')->text();
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
                            $data['gameimg'] = 'http://45.157.91.154/static/'.$filename;
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
                            $data['gameimg'] = 'http://45.157.91.154/static/'.$filename;
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
                            $data['gameimg'] = 'http://45.157.91.154/static/'.$filename;
                        }

                        $data['events'] = $node->filter('div.leagues > p')->text();

                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'],$data['game']);
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
                            $events['game'] = $data['game'];

                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在'){
                                $matchspider = new MatchSpiderController();
                                $matchspider->AllMatch($events);
                            }

                        }

                        $data['exponent'] = $node->filter('div.odd')->text();
//                        dd($data);
                        return $data;
                    });
                    DB::table('scorenot')->truncate();
                    DB::table('scorenot')->insert($arr);


//                    $bool = DB::table('title')->insert($arr);
//                    echo $bool;
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

    // 比分  完场
    public function scoreover()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        for ($i = 1; $i < 2; $i++) {
            $this->url[] = 'https://www.500bf.com/index/index/score?type=0&subtype=1';
        }
        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->get($uri, ['verify' => false]);
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
                    $arr = $crawler->filter('body > div.body > div.score-warpper.default-continer > div.score-list-panel > div.match-wait-panel-wrapper > div.container > div')->each(function ($node, $i) use ($http) {
                        $data['gameimg'] = 'https://www.500bf.com'.$node->filter('img')->attr('src');
                        // 所属游戏
                        if (strpos($data['gameimg'], 'dota') !== false) {
                            $data['game'] = 'DOTA2';
                        } elseif (strpos($data['gameimg'], 'csgo') !== false) {
                            $data['game'] = 'CS:GO';
                        } elseif (strpos($data['gameimg'], 'lol') !== false) {
                            $data['game'] = '英雄联盟';
                        } elseif (strpos($data['gameimg'], 'kog') !== false) {
                            $data['game'] = '王者荣耀';
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


                        $data['time'] = $node->filter('p.match-item-time')->text();
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
                        }catch (\Exception $exception){
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
                        $events_id = $Match->GetMatchId($data['events'],$data['game']);
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

                            $events['game'] = $data['game'];
                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在'){
                                $matchspider = new MatchSpiderController();
                                $matchspider->AllMatch($events);
                            }
                        }

                        $data['exponent'] = $node->filter('div.odd')->text();
//                        dd($data);
                        return $data;
                    });
                    DB::table('scoreover')->truncate();
                    DB::table('scoreover')->insert($arr);


//                    $bool = DB::table('title')->insert($arr);
//                    echo $bool;
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

    // 比分  即时
    public function scoreing()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        for ($i = 1; $i < 2; $i++) {
            $this->url[] = 'https://www.500bf.com/index/index/score?type=0&subtype=0';
        }
        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->get($uri, ['verify' => false]);
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
                    $arr = $crawler->filter('#score_living > div > div > div.live_container > div')->each(function ($node, $i) use ($http) {
                        $data['gameimg'] = 'https://www.500bf.com'.$node->filter('div > div > div.header > img')->attr('src');
                        // 所属游戏
                        if (strpos($data['gameimg'], 'dota') !== false) {
                            $data['game'] = 'DOTA2';
                        } elseif (strpos($data['gameimg'], 'csgo') !== false) {
                            $data['game'] = 'CS:GO';
                        } elseif (strpos($data['gameimg'], 'lol') !== false) {
                            $data['game'] = '英雄联盟';
                        } elseif (strpos($data['gameimg'], 'kog') !== false) {
                            $data['game'] = '王者荣耀';
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

                        $data['events'] = $node->filter('div > div > div.header > p.name')->text();

                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'],$data['game']);
                        if ($events_id) {
                            $data['eventsid'] = $events_id;
                        } else { // 赛事不存在，需新增
                            try {
                                $events_onclick = $node->filter('div > div > div.header > p.name')->attr('onclick');
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
                            $events['game'] = $data['game'];

                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在'){
                                $matchspider = new MatchSpiderController();
                                $matchspider->AllMatch($events);
                            }
                        }

                        $data['tag'] = $node->filter('div > div > div.header > p:nth-child(3)')->text();
                        $data['tag1'] = $node->filter('div > div > div.header > p:nth-child(4)')->text();
                        $data['tag2'] = $node->filter('div > div > div.header > div > p:nth-child(1)')->text();
                        $data['tag3'] = $node->filter('div > div > div.header > div > p:nth-child(2)')->text();
                        try {
                            $data['tag4'] = $node->filter('div > div > div.header > div > p:nth-child(3)')->text();
                        }catch (\Exception $exception){
                            $data['tag4'] = '';
                        }
                        try {
                            $data['tag5'] = $node->filter('div > div > div.header > div > p:nth-child(4)')->text();
                        }catch (\Exception $exception){
                            $data['tag5'] = '';
                        }
                        try {
                            $data['tag6'] = $node->filter('div > div.header > div.tag-panel > p:nth-child(5)')->text();
                        } catch (\Exception $exception) {
                            $data['tag6'] = '';
                        }

                        $data['exponent'] = $node->filter('div > div > div.header > p.tag.bet')->text();

                        $arr = array();
                        // 开始处理直播地址 #div > div.header > div > div > ul > li   div > div.header > div.videos-panel.video-panel > ul > li
                        #div > div.header > div.videos-panel.video-panel > ul > li
                        if ( $data['game'] == '英雄联盟'){
                            $tv_arr = $node->filter('div > div.header > div.videos-panel.video-panel > ul > li')->each(function ($node2, $i) use ($arr) {
                                $arr = array_add($arr, $node2->filter('a > span')->text(), 'https://www.500bf.com' . $node2->filter('a')->attr('href'));
                                return $arr;
                            });
                        }else{
                            $tv_arr = $node->filter('div > div.header > div > div > ul > li')->each(function ($node2, $i) use ($arr) {
                                $arr = array_add($arr, $node2->filter('a > span')->text(), 'https://www.500bf.com' . $node2->filter('a')->attr('href'));
                                return $arr;
                            });
                        }

                        $data['tv'] = '';
                        if (!empty($tv_arr)) {
                            foreach ($tv_arr as $value) {
                                $tv_client = new Client();
                                $tv_response = $tv_client->get(current($value), ['verify' => false]);
                                $tv_http = $tv_response->getBody()->getContents();
                                if (strpos($tv_http, '500电竞比分网') !== false) {
                                    $iframe = substr($tv_http, strpos($tv_http, "class=\"live-iframe\"") + 20);
                                    $iframe = substr($iframe, 0, strpos($iframe, '">'));
                                    $data['tv'] = $data['tv'] . key($value) . "=>" . substr($iframe, strpos($iframe, 'http')) . "|";
                                } else {
                                    $data['tv'] = $data['tv'] . key($value) . "=>" . current($value) . "|";
                                }
//                                echo current($value);
                            }
                        }
                        $data['now'] = $node->filter('div > div > div.content > div.match-info > p:nth-child(1)')->text();
                        $data['nowtime'] = $node->filter('div > div > div.content > div.match-info > p:nth-child(2)')->text();

                        $data['team1img'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.team > img')->attr('src');

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

                        $data['team1'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.team > p')->text();
                        $data['team1winnum'] = (integer)$node->filter('div > div > div.content > div.team-info > div:nth-child(1) > p:nth-child(2)')->text();
                        $data['team1lineup'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > p:nth-child(3)')->text();
                        $data['team1killnum'] = (integer)$node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div:nth-child(4) > p')->text();

                        try {
                            // 开始处理特殊图标   图标可能为空  可能为一个或多个
                            $data['team1killspecial'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div:nth-child(4) > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });
                            if (is_array($data['team1killspecial']))
                                $data['team1killspecial'] = implode("|", $data['team1killspecial']);
                        } catch (\Exception $e) {
                            $data['team1killspecial'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div.tag.kill > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });
                            if (is_array($data['team1killspecial']))
                                $data['team1killspecial'] = implode("|", $data['team1killspecial']);
                        }

                        try {
                            $data['team1tag3num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.first-half > p')->text();
                        } catch (\Exception $exception) {
                            try {
                                $data['team1tag3num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.pl-8 > p')->text();
                            }catch (\Exception $exception) {
                                try{
                                    $data['team1tag3num'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(5) > p')->text();
                                }catch (\Exception $exception) {
                                    $data['team1tag3num'] = '';
                                }
                            }
                        }
                        try {
                            $data['team1tag3special'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.first-half > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });//div > div.content > div.team-info > div:nth-child(2) > div:nth-child(5) > img
                            if (is_array($data['team1tag3special']))
                                $data['team1tag3special'] = implode("|", $data['team1tag3special']);
                        } catch (\Exception $e) {
                            try {
                                $data['team1tag3special'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(5) > img')->each(function ($node3, $i) {
                                    return 'https://www.500bf.com' . $node3->attr('src');
                                });//
                                if (is_array($data['team1tag3special']))
                                    $data['team1tag3special'] = implode("|", $data['team1tag3special']);
                            }catch (\Exception $exception){
                                $data['team1tag3special'] = '';
                            }
                        }
                        if ($data['tag4'] !== ''){
                            try {
                                $data['team1tag4num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.sconde-half > p')->text();
                            } catch (\Exception $exception) {
                                $data['team1tag4num'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(6) > p')->text();
                            }
                        }else{
                            $data['team1tag4num'] = '';
                        }

                        try {
                            $data['team1tag4special'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.sconde-half > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });
                            if (is_array($data['team1tag4special']))
                                $data['team1tag4special'] = implode("|", $data['team1tag4special']);
                        } catch (\Exception $e) {
                            $data['team1tag4special'] = '';
                        }
                        if($data['tag5'] !== ''){
                            try {
                                $data['team1tag5num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.over-time > p')->text();
                            } catch (\Exception $exception) {
                                $data['team1tag5num'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(7) > p')->text();
                            }
                        } else {
                            $data['team1tag5num'] = '';
                        }

                        try {
                            $data['team1tag5special'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(7) > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });
                            if (is_array($data['team1tag5special']))
                                $data['team1tag5special'] = implode("|", $data['team1tag5special']);
                        } catch (\Exception $e) {
                            $data['team1tag5special'] = '';
                        }
                        if ($data['tag6'] !== ''){
                            $data['team1tag6num'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(8)')->text();
                        } else {
                            $data['team1tag6num'] = '';
                        }
                        $data['team1indexnum'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.bet > p')->text();


                        $data['team2img'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.team > img')->attr('src');

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

                        $data['team2'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.team > p')->text();
                        $data['team2winnum'] = (integer)$node->filter('div > div > div.content > div.team-info > div:nth-child(2) > p:nth-child(2)')->text();
                        $data['team2lineup'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > p:nth-child(3)')->text();
                        $data['team2killnum'] = (integer)$node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div:nth-child(4) > p')->text();
                        try {
                            $data['team2killspecial'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div:nth-child(4) > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });
                            if (is_array($data['team2killspecial']))
                                $data['team2killspecial'] = implode("|", $data['team2killspecial']);
                        } catch (\Exception $e) {
                            $data['team2killspecial'] = '';
                        }
                        try {
                            $data['team2tag3num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.first-half > p')->text();
                        } catch (\Exception $e) {
                            try{
                                $data['team2tag3num'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(5) > p')->text();
                            }catch (\Exception $exception){
                                try{
                                    $data['team2tag3num'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(5)')->text();
                                }catch (\Exception $exception){
                                    $data['team2tag3num'] = '';
                                }
                            }
                        }
                        try {
                            $data['team2tag3special'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.first-half > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });
                            if (is_array($data['team2tag3special']))
                                $data['team2tag3special'] = implode("|", $data['team2tag3special']);
                        } catch (\Exception $e) {
                            try {
                                $data['team2tag3special'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(5) > img')->each(function ($node3, $i) {
                                    return 'https://www.500bf.com' . $node3->attr('src');
                                });
                                if (is_array($data['team2tag3special']))
                                    $data['team2tag3special'] = implode("|", $data['team2tag3special']);
                            }catch (\Exception $e){
                                $data['team2tag3special'] = '';
                            }

                        }
                        if ($data['tag4'] !== ''){
                            try {
                                $data['team2tag4num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.sconde-half > p')->text();
                            } catch (\Exception $e) {
                                $data['team2tag4num'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(6) > p')->text();
                            }
                        }else {
                            $data['team2tag4num'] = '';
                        }

                        try {
                            $data['team2tag4special'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(6) > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });
                            if (is_array($data['team2tag4special']))
                                $data['team2tag4special'] = implode("|", $data['team2tag4special']);
                        } catch (\Exception $e) {
                            $data['team2tag4special'] = '';
                        }
                        if ($data['tag5'] !== ''){
                            try {
                                $data['team2tag5num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.over-time > p')->text();
                            } catch (\Exception $e) {
                                $data['team2tag5num'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(7) > p')->text();
                            }
                        }else{
                            $data['team2tag5num'] = '';
                        }

                        try {
                            $data['team2tag5special'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.over-time > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });#div > div.content > div.team-info > div:nth-child(2) > div:nth-child(7) > img
                            if (is_array($data['team2tag5special']))
                                $data['team2tag5special'] = implode("|", $data['team2tag5special']);
                        } catch (\Exception $e) {
                            try {
                                $data['team2tag5special'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(7) > img')->each(function ($node3, $i) {
                                    return 'https://www.500bf.com' . $node3->attr('src');
                                });#
                                if (is_array($data['team2tag5special']))
                                    $data['team2tag5special'] = implode("|", $data['team2tag5special']);
                            }catch (\Exception $e){
                                $data['team2tag5special'] = '';
                            }
                        }
                        $data['team2tag6num'] = '';
                        $data['team2indexnum'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.bet > p')->text();


//                        dd($data);
                        return $data;
                    });
//                    dd($arr);
                    DB::table('scoreing')->truncate();
                    DB::table('scoreing')->insert($arr);


//                    $bool = DB::table('title')->insert($arr);
//                    echo $bool;
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
