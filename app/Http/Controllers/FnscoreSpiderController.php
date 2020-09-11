<?php

namespace App\Http\Controllers;

use App\Match;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
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

        $arr = array();
        if (count($json_arr) > 0) {
            foreach ($json_arr as $key => $item) {
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
                $arr[$key]['match'] = $item['league']['leagueName'];

                $Match = new Match();
                $eventsid = $Match->GetMatchId($arr[$key]['match'], $arr[$key]['game']);
                $eventsid = false;
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

                    // 增加赛事
                    $match['match'] = $item['league']['leagueName'];
                    $match['matchimg'] = $item['league']['logo'];
                    $start_time = $item['league']['startTime'] / 1000;
                    $end_time = $item['league']['endTime'] / 1000;
                    $match['matchtime'] = date('Y-m-d',$start_time).' - '.date('Y-m-d',$end_time);
                    $match['teams'] = count($item['league']['teamIds']).'支';
                    $match['money'] = $item['league']['prize'];
                    $match['venue'] = $item['league']['address'];
                    $match['organizers'] = $item['league']['organizer'];
                    $match['game'] = $arr[$key]['game'];
                    $match['link'] = $link;

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
                    $t = $crawler->filter('#__layout > div > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.title > h3')->text();
                    $a = $crawler->filter('#__layout > div > div.detail-wrapper.default-continer > div.detail-container > div.match-panel-wrapper > div.match-panel-container > div')->each(function ($node,$i){
                        if ($i > 0){
                            $array['time'] = $node->filter('p:nth-child(1)')->text();
                            $array['team1img'] = $node->filter('div:nth-child(2) > img')->attr('src');


                            return $array;
                        }

                    });
                    if (count($a) == 0){
                        $a = $crawler->filter('#__layout > div > div.detail-wrapper.default-continer > div.detail-container > div.league-group-rank > div > div.league-info-panel > div.match-progress > div')->each(function ($node,$i){
                            if ($i > 0){
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
                    dd($a);

                }

                $arr[$key]['videos'] = '';
                if (count($item['videos']) > 0) {
                    foreach ($item['videos'] as $video) {
                        $arr[$key]['videos'] = $arr[$key]['videos'] . $video['videoName'] . '=>' . $video['videoUrl'] . '|';
                    }
                }

                $arr[$key]['time'] = (int)$item['matchTime'] / 1000;
                $arr[$key]['team1'] = $item['home']['teamName'];
                $arr[$key]['team1logo'] = $item['home']['logo'];
                $arr[$key]['team1score'] = $item['homeScore'];
                $arr[$key]['team2score'] = $item['awayScore'];
                $arr[$key]['team2'] = $item['away']['teamName'];
                $arr[$key]['team2logo'] = $item['away']['logo'];
                $arr[$key]['bo'] = $item['bo'];


            }
        }


    }


    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount) {
            return;
        }
    }
}
