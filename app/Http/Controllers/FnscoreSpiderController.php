<?php

namespace App\Http\Controllers;

use App\Match;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;
use function foo\func;

class FnscoreSpiderController extends Controller
{
    //
    //
    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 300;  // 同时并发抓取

    protected $startUrl = 'https://www.autotimes.com.cn/news/1.html';

    // 首页正在进行全部游戏
    public function index()
    {

        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $uri = 'https://www.fnscore.com/api/common/getMatchLives?timestamp=1599198082859&sign=p1E%252Bcis2nVMRXEtWz3xdL7yHMxvJUHBQmNU0g9U5PSU%253D';
//        $uri = 'https://www.fnscore.com/api/common/getMatchLiveBattle?timestamp=1599381688257&sign=SI0O6Y1wfo2nT9BMqCTe45h5Tj7nyfUclpTTAJnPSvg%253D';

        $this->totalPageCount = 1500;
        $client = new Client();
        $req = $client->post($uri, ['verify' => false,
            'headers' => [
                'Content-Type' => 'application/json; charset=utf-8',
                'cookie' => 'Hm_lvt_f9784b3edd94d69659d8e4abfed9b281=1598236985,1598499176; Hm_lpvt_f9784b3edd94d69659d8e4abfed9b281=1598513879',
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.100 Safari/537.36',
                'dataType' => 'json',
                'X-Content-Type-Options' => 'nosniff',
            ]]);

        $post = $req->getBody()->getContents();
        $jsons = json_decode($post, true);
        foreach ($jsons as $json) {
            $json_arr = $json;
        }
//        dd($json_arr);
        $img_client = new Client();
        $arr = array();
        if (count($json_arr) > 0) {
            foreach ($json_arr as $key => $item) {
                $arr[$key]['eventsimg'] = $item['league']['logo'];
                $arr[$key]['events'] = $item['league']['leagueName'];
                switch ((int)$item['gameType']) {
                    case 1:
                        $arr[$key]['game'] = '英雄联盟';
                        break;
                    case 2:
                        $arr[$key]['game'] = '王者荣耀';
                        break;
                    case 3:
                        $arr[$key]['game'] = 'CS:GO';
                        break;
                    case 4:
                        $arr[$key]['game'] = 'DOTA2';
                        break;
                }

                $Match = new Match();
                $eventsid = $Match->GetMatchId($arr[$key]['events'], $arr[$key]['game']);

                if ($eventsid) {
                    $arr[$key]['eventsid'] = $eventsid;
                } else {
                    // 开始处理赛事
                    if ($arr[$key]['game'] == '英雄联盟') {
                        $link = 'https://www.fnscore.com/detail/league/lol-1/league-lol-' . $item['league']['leagueId'] . '.html';
                    }
                    if ($arr[$key]['game'] == '王者荣耀') {
                        $link = 'https://www.fnscore.com/detail/league/kog-2/league-kog-' . $item['league']['leagueId'] . '.html';
                    }
                    if ($arr[$key]['game'] == 'CS:GO') {
                        $link = 'https://www.fnscore.com/detail/league/csgo-3/league-csgo-' . $item['league']['leagueId'] . '.html';
                    }
                    if ($arr[$key]['game'] == 'DOTA2') {
                        $link = 'https://www.fnscore.com/detail/league/dota-4/league-dota-' . $item['league']['leagueId'] . '.html';
                    }
                    $match = array();
                    // 增加赛事
                    $match['match'] = $item['league']['leagueName'];
                    $match['matchimg'] = $item['league']['logo'];
                    $start_time = $item['league']['startTime'] / 1000;
                    $end_time = $item['league']['endTime'] / 1000;
                    $match['matchtime'] = date('Y-m-d', $start_time) . ' - ' . date('Y-m-d', $end_time);
                    $match['teams'] = count($item['league']['teamIds']) . '支';
                    $match['money'] = $item['league']['prize'];
                    $match['venue'] = $item['league']['address'];
                    $match['organizers'] = $item['league']['organizer'];
                    $match['game'] = $arr[$key]['game'];
                    $match['timestamp'] = strtotime(date('Y-m-d', $end_time));
                    $match['link'] = $link;

                    $arr[$key]['eventsid'] = DB::table('match')->insertGetId($match);

                    $a = $this->FnScoreLeague($link,$match['match'],$arr[$key]['eventsid']);
                    DB::table('schedulematch')->insert(array_filter($a));

                }

                $arr[$key]['tv'] = '';
                if (count($item['videos']) > 0) {
                    foreach ($item['videos'] as $video) {
                        $arr[$key]['tv'] = $arr[$key]['tv'] . $video['videoName'] . '=>' . $video['videoUrl'] . '|';
                    }
                }

                $arr[$key]['now'] = $item['homeScore'] + $item['awayScore'];
                $arr[$key]['BO'] = $item['bo'];
                $arr[$key]['pooreconomy'] = '';
                $arr[$key]['team1img'] = $item['home']['logo'];
                $arr[$key]['team1'] = $item['home']['teamName'];
                $arr[$key]['team1winnum'] = $item['homeScore'];
                $arr[$key]['team1killnum'] = 0;
                $arr[$key]['team1special'] = '';
                $arr[$key]['team2img'] = $item['away']['logo'];
                $arr[$key]['team2'] = $item['away']['teamName'];
                $arr[$key]['team2winnum'] = $item['awayScore'];
                $arr[$key]['team2killnum'] = 0;
                $arr[$key]['team2special'] = '';
//                $arr[$key]['time'] = $item['matchTime'] / 1000;








            }

            DB::table('allmatching')->insert($arr);
//            dd($arr);
        }


    }



    public function ListWait(){

        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $uri = 'https://www.fnscore.com/api/common/getMatchListWait?timestamp=1599296134666&sign=fyhQKpyAe7%252BfzLMX%252Fi%252FZTHdTDTwVjtaHYgdpEhGkShQ%253D';
//        $uri = 'https://www.fnscore.com/api/common/getMatchLiveBattle?timestamp=1599381688257&sign=SI0O6Y1wfo2nT9BMqCTe45h5Tj7nyfUclpTTAJnPSvg%253D';

        $this->totalPageCount = 1500;
        $client = new Client();
        $req = $client->post($uri, ['verify' => false,
            'headers' => [
                'Content-Type' => 'application/json; charset=utf-8',
                'cookie' => 'Hm_lvt_f9784b3edd94d69659d8e4abfed9b281=1598236985,1598499176; Hm_lpvt_f9784b3edd94d69659d8e4abfed9b281=1598513879',
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.100 Safari/537.36',
                'dataType' => 'json',
                'X-Content-Type-Options' => 'nosniff',
            ]]);

        $post = $req->getBody()->getContents();
        $jsons = json_decode($post, true);
        foreach ($jsons as $json) {
            $json_arr = $json;
        }
//        dd($json_arr);
        $img_client = new Client();
        $arr = array();
        if (count($json_arr) > 0) {
            foreach ($json_arr as $key => $item) {
                switch ($item['gameType']) {
                    case 1:
                        $arr[$key]['gameimg'] = 'http://45.157.91.154/static/lol_sel_icon.png';
                        $arr[$key]['game'] = '英雄联盟';
                        break;
                    case 2:
                        $arr[$key]['gameimg'] = 'http://45.157.91.154/static/kog_sel_icon.png';
                        $arr[$key]['game'] = '王者荣耀';
                        break;
                    case 3:
                        $arr[$key]['gameimg'] = 'http://45.157.91.154/static/csgo_sel_icon.png';
                        $arr[$key]['game'] = 'CS:GO';
                        break;
                    case 4:
                        $arr[$key]['gameimg'] = 'http://45.157.91.154/static/dota_sel_icon.png';
                        $arr[$key]['game'] = 'DOTA2';
                        break;
                }
                $time = $item['matchTime'] / 1000;
                $arr[$key]['time'] = date('H:i',$time);
                $arr[$key]['BO'] = $item['bo'];
                $arr[$key]['team1'] = $item['home']['teamName'];
                $arr[$key]['team1img'] = $item['home']['logo'];
                $arr[$key]['team2img'] = $item['away']['logo'];
                $arr[$key]['team2'] = $item['away']['teamName'];





            }

            DB::table('allmatching')->insert($arr);
//            dd($arr);
        }
    }





    public function FnScoreLeague($link,$event,$event_id){
        $client = new Client();
        $http = $client->get($link, ['verify' => false,
            'headers' => [
                'Content-Type' => 'text/html; charset=utf-8',
                'cookie' => 'Hm_lvt_f9784b3edd94d69659d8e4abfed9b281=1598236985,1598499176; Hm_lpvt_f9784b3edd94d69659d8e4abfed9b281=1598513879',
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.100 Safari/537.36',
                'X-Content-Type-Options' => 'nosniff',]
        ]);
        $content = $http->getBody()->getContents();
        $crawler = new Crawler();
        $crawler->addHtmlContent($content);
        $a = $crawler->filter('#__layout > div > div.detail-wrapper.default-continer > div.detail-container > div.match-panel-wrapper > div.match-panel-container > div')->each(function ($node, $i) use ($event,$event_id) {
            if ($i > 0) {
                $array['event'] = $event;
                $array['eventid'] = $event_id;
                $array['time'] = $node->filter('p:nth-child(1)')->text();
                $array['team1img'] = $node->filter('div:nth-child(2) > img')->attr('src');
                $array['team1'] = $node->filter('div:nth-child(2) > p')->text();
                $array['score'] = $node->filter('p.score-wait')->text();
                $array['team2img'] = $node->filter('div:nth-child(4) > img')->attr('src');
                $array['team2'] = $node->filter('div:nth-child(4) > p')->text();
                $array['BO'] = $node->filter('p:nth-child(5)')->text();
                return $array;
            }

        });
        if (count($a) == 0) {
            $a = $crawler->filter('#__layout > div > div.detail-wrapper.default-continer > div.detail-container > div.league-group-rank > div > div.league-info-panel > div.match-progress > div')->each(function ($node, $i) use ($event,$event_id) {
                if ($i > 0) {
                    $array['event'] = $event;
                    $array['eventid'] = $event_id;
                    $array['time'] = $node->filter('p:nth-child(1)')->text();
                    $array['team1img'] = $node->filter('div:nth-child(2) > img')->attr('src');
                    $array['team1'] = $node->filter('div:nth-child(2) > p')->text();
                    $array['score'] = $node->filter('p:nth-child(3)')->text();
                    $array['team2img'] = $node->filter('div:nth-child(4) > img')->attr('src');
                    $array['team2'] = $node->filter('div:nth-child(4) > p')->text();
                    $array['BO'] = $node->filter('p:nth-child(5)')->text();
                    return $array;
                }
            });
        }




        return $a;
    }


    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount) {
            return;
        }
    }
}
