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
                if (ob_get_level() > 0)
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
                        if (strpos($data['eventsimg'], 'dota') !== false) {
                            $data['game'] = 'DOTA2';
                        } elseif (strpos($data['eventsimg'], 'csgo') !== false) {
                            $data['game'] = 'CS:GO';
                        } elseif (strpos($data['eventsimg'], 'lol') !== false) {
                            $data['game'] = '英雄联盟';
                        } elseif (strpos($data['eventsimg'], 'kog') !== false) {
                            $data['game'] = '王者荣耀';
                        } else {
                            $find_onclick = $node->filter('div > div.header > div')->attr('onclick');
                            $find_link = substr($find_onclick, strpos($find_onclick, 'hrefClicked(\'') + 13);
                            $find_link = substr($find_link, 0, strpos($find_link, '\')'));
                            $events_link = $find_link;
                            $find_client = new Client();
                            $find_response = $find_client->get('https://www.500bf.com' . $find_link, ['verify' => false]);
                            $find_request = $find_response->getBody()->getContents();

                            if (strpos($find_request, '/dota/team') !== false) {
                                $data['game'] = 'DOTA2';
                            } elseif (strpos($find_request, '/csgo/team')) {
                                $data['game'] = 'CS:GO';
                            } elseif (strpos($find_request, '/lol/team')) {
                                $data['game'] = '英雄联盟';
                            } elseif (strpos($find_request, '/kog/team')) {
                                $data['game'] = '王者荣耀';
                            }


                        }

                        $client_img = new Client(['verify' => false]);
                        $filename = substr($data['eventsimg'], strrpos($data['eventsimg'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['eventsimg'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['eventsimg'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                                $data['eventsimg'] = '';
                            }

                        } else {
                            $data['eventsimg'] = 'http://45.157.91.154/static/' . $filename;
                        }


                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'], $data['game']);

                        $events_onclick = $node->filter('div > div.header > div')->attr('onclick');
                        $events_link = substr($events_onclick, strpos($events_onclick, 'hrefClicked(\'') + 13);
                        $events_link = substr($events_link, 0, strpos($events_link, '\')'));

                        if ($events_id) {
                            $ma = DB::table('match')->where('id', $events_id)->get()->toArray();
                            if (strpos($ma[0]->link, '500bf') !== false) {
                                $id = substr($events_link, strpos($events_link, '/id/') + 4);
                                $id = substr($id, 0, strpos($id, '.html'));
                                if ($data['game'] == '英雄联盟') {
                                    $link = 'https://www.fnscore.com/detail/league/lol-1/league-lol-' . $id . '.html';
                                } elseif ($data['game'] == '王者荣耀') {
                                    $link = 'https://www.fnscore.com/detail/league/kog-2/league-kog-' . $id . '.html';
                                } elseif ($data['game'] == 'CS:GO') {
                                    $link = 'https://www.fnscore.com/detail/league/csgo-3/league-csgo-' . $id . '.html';
                                } elseif ($data['game'] == 'DOTA2') {
                                    $link = 'https://www.fnscore.com/detail/league/dota-4/league-dota-' . $id . '.html';
                                }
                                DB::table('match')->where('id', $events_id)->update(['link' => $link]);
                            }
                            $data['eventsid'] = $events_id;
                        } else { // 赛事不存在，需新增

                            $id = substr($events_link, strpos($events_link, '/id/') + 4);
                            $id = substr($id, 0, strpos($id, '.html'));
                            if ($data['game'] == '英雄联盟') {
                                $link = 'https://www.fnscore.com/detail/league/lol-1/league-lol-' . $id . '.html';
                            } elseif ($data['game'] == '王者荣耀') {
                                $link = 'https://www.fnscore.com/detail/league/kog-2/league-kog-' . $id . '.html';
                            } elseif ($data['game'] == 'CS:GO') {
                                $link = 'https://www.fnscore.com/detail/league/csgo-3/league-csgo-' . $id . '.html';
                            } elseif ($data['game'] == 'DOTA2') {
                                $link = 'https://www.fnscore.com/detail/league/dota-4/league-dota-' . $id . '.html';
                            }
                            if ($find_request) {
                                $events_crawler = new Crawler();
                                $events_crawler->addHtmlContent($find_request);
                            } else {
                                $events_client = new Client();
                                $events_response = $events_client->get('https://www.500bf.com' . $events_link, ['verify' => false]);
                                $events_request = $events_response->getBody()->getContents();
                                $events_crawler = new Crawler();
                                $events_crawler->addHtmlContent($events_request);
                            }

                            $events['match'] = $data['events'];
                            $events['matchimg'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-logo > img')->attr('src');
                            $filename = substr($events['matchimg'], strrpos($events['matchimg'], '/') + 1);
                            if (!file_exists(public_path('static/' . $filename))) {
                                try {
                                    $resp = $client_img->get($events['matchimg'], ['save_to' => public_path('static/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }

                            } else {
                                $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
                            }
                            $events['matchtime'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.match-time > div > p:nth-child(2)')->text();
                            $events['teams'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.teamIds > div > p:nth-child(2)')->text();
                            $events['money'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.prize > div > p:nth-child(2)')->text();
                            $events['venue'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.address > div > p:nth-child(2)')->text();
                            $events['organizers'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.organizer > div > p:nth-child(2)')->text();

                            $events['game'] = $data['game'];
                            $endtime = substr($events['matchtime'], strpos($events['matchtime'], '- ') + 2);
                            $events['timestamp'] = strtotime($endtime);
                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            $events['matchid'] = $data['eventsid'];
                            $fnscore = new FnscoreSpiderController();

                            $a = $fnscore->FnScoreLeague($link, $events['match'], $data['eventsid']);

                            DB::table('schedulematch')->insert($a);
//                            if ($events['matchimg'] !== '该赛事内容不存在') {
//                                $matchspider = new MatchSpiderController();
//                                $matchspider->AllMatch($events);
//                            }


                        }


                        $arr = array();
                        // 开始处理直播地址
                        try {
                            $tv_arr = $node->filter('div > div.header > div.videos-panel > ul > li')->each(function ($node2, $i) use ($arr) {
                                $arr = array_add($arr, $node2->filter('a > span')->text(), 'https://www.500bf.com' . $node2->filter('a')->attr('href'));
                                return $arr;
                            });
                        } catch (\Exception $exception) {
                            $tv_arr = null;
                        }

                        $data['tv'] = '';

                        try {
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
                        } catch (\Exception $exception) {
                        }


                        $data['now'] = $node->filter('div > div.item-row-title > div.tag-1 > p')->text();
                        $data['BO'] = $node->filter('div > div.item-row-title > div.tag-2 > p')->text();
                        try {
                            $data['pooreconomy'] = $node->filter('div > div.item-row-title > div.tag-3 > p')->text();
                        } catch (\Exception $exception) {
                            $data['pooreconomy'] = '0K';
                        }
                        $data['team1img'] = $tema1img;

                        $filename = substr($data['team1img'], strrpos($data['team1img'], '/') + 1);

                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['team1img'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
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

                        $filename = substr($data['team2img'], strrpos($data['team2img'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['team2img'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }
                        } else {
                            $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
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
                    $fn = new FnscoreSpiderController();
                    $fn->index();
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
                if (ob_get_level() > 0)
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
                        $filename = substr($data['gameimg'], strrpos($data['gameimg'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get('https://www.500bf.com' . $data['gameimg'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['gameimg'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['gameimg'] = 'http://45.157.91.154/static/' . $filename;
                        }


                        $data['time'] = $node->filter('p.match-item-time')->text();
                        $data['BO'] = $node->filter('p.match-item-bo')->text();
                        $data['team1'] = $node->filter('div.home-team > p')->text();
                        $data['team1img'] = $node->filter('div.home-team > img')->attr('src');


                        $filename = substr($data['team1img'], strrpos($data['team1img'], '/') + 1);
                        if (strpos($data['team1img'], '/lol/team.png') !== false) {
                            $data['team1img'] = 'http://45.157.91.154/static/lolteam.png';
                        } elseif (strpos($data['team1img'], '/kog/team.png') !== false) {
                            $data['team1img'] = 'http://45.157.91.154/static/kogteam.png';
                        } elseif (strpos($data['team1img'], 'dota/team.png')) {
                            $data['team1img'] = 'http://45.157.91.154/static/dotateam.png';
                        } else {
                            if (!file_exists(public_path('static/' . $filename))) {
                                try {
                                    $resp = $client_img->get($data['team1img'], ['save_to' => public_path('static/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }

                            } else {
                                $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                            }
                        }


                        $data['team2img'] = $node->filter('div.away-team > img')->attr('src');

                        $filename = substr($data['team2img'], strrpos($data['team2img'], '/') + 1);

                        if (strpos($data['team2img'], '/lol/team.png') !== false) {
                            $data['team2img'] = 'http://45.157.91.154/static/lolteam.png';
                        } elseif (strpos($data['team2img'], '/kog/team.png') !== false) {
                            $data['team2img'] = 'http://45.157.91.154/static/kogteam.png';
                        } elseif (strpos($data['team2img'], 'dota/team.png')) {
                            $data['team2img'] = 'http://45.157.91.154/static/dotateam.png';
                        } else {
                            if (!file_exists(public_path('static/' . $filename))) {
                                try {
                                    $resp = $client_img->get($data['team2img'], ['save_to' => public_path('static/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }

                            } else {
                                $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                            }
                        }

                        $data['team2'] = $node->filter('div.away-team > p')->text();
                        $data['eventsimg'] = $node->filter('div.league > img')->attr('src');

                        $filename = substr($data['eventsimg'], strrpos($data['eventsimg'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['eventsimg'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['eventsimg'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['eventsimg'] = 'http://45.157.91.154/static/' . $filename;
                        }

                        $data['events'] = $node->filter('div.league > p')->text();

                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'], $data['game']);
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

                            $filename = substr($events['matchimg'], strrpos($events['matchimg'], '/') + 1);
                            if (!file_exists(public_path('static/' . $filename))) {
                                try {
                                    $resp = $client_img->get($events['matchimg'], ['save_to' => public_path('static/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }

                            } else {
                                $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
                            }

                            $events['matchtime'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.match-time > div > p:nth-child(2)')->text();
                            $events['teams'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.teamIds > div > p:nth-child(2)')->text();
                            $events['money'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.prize > div > p:nth-child(2)')->text();
                            $events['venue'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.address > div > p:nth-child(2)')->text();
                            $events['organizers'] = $events_crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-header > div.league-content > div.league-info > div.item.organizer > div > p:nth-child(2)')->text();

                            $events['game'] = $data['game'];
                            $endtime = substr($events['matchtime'], strpos($events['matchtime'], '- ') + 2);
                            $events['timestamp'] = strtotime($endtime);
                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在') {
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
                if (ob_get_level() > 0)
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
                        $data['gameimg'] = 'https://www.500bf.com' . $node->filter('img')->attr('src');


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
                        $filename = substr($data['gameimg'], strrpos($data['gameimg'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get('https://www.500bf.com' . $data['gameimg'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['gameimg'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['gameimg'] = 'http://45.157.91.154/static/' . $filename;
                        }


                        $data['time'] = $node->filter('p.match-item-time')->text();
                        $data['BO'] = $node->filter('p.match-item-bo')->text();
                        $data['team1'] = $node->filter('div.home-team > p')->text();
                        $data['team1img'] = $node->filter('div.home-team > img')->attr('src');

                        $filename = substr($data['team1img'], strrpos($data['team1img'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['team1img'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                        }

                        $data['team2img'] = $node->filter('div.away-team > img')->attr('src');

                        $filename = substr($data['team2img'], strrpos($data['team2img'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['team2img'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                        }

                        $data['team2'] = $node->filter('div.away-team > p')->text();
                        $data['eventsimg'] = $node->filter('div.leagues > img')->attr('src');

                        $filename = substr($data['eventsimg'], strrpos($data['eventsimg'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['eventsimg'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['eventsimg'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['eventsimg'] = 'http://45.157.91.154/static/' . $filename;
                        }

                        $data['events'] = $node->filter('div.leagues > p')->text();

                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'], $data['game']);
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
                                $filename = substr($events['matchimg'], strrpos($events['matchimg'], '/') + 1);
                                if (!file_exists(public_path('static/' . $filename))) {
                                    try {
                                        $resp = $client_img->get($events['matchimg'], ['save_to' => public_path('static/' . $filename)]);
                                        if ($resp->getStatusCode() == 200) {
                                            $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
                                        }
                                    } catch (\Exception $exception) {
                                    }

                                } else {
                                    $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
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
                            $endtime = substr($events['matchtime'], strpos($events['matchtime'], '- ') + 2);
                            $events['timestamp'] = strtotime($endtime);
                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在') {
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
                if (ob_get_level() > 0)
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
                        $data['gameimg'] = 'https://www.500bf.com' . $node->filter('img')->attr('src');
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
                        $filename = substr($data['gameimg'], strrpos($data['gameimg'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get('https://www.500bf.com' . $data['gameimg'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['gameimg'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['gameimg'] = 'http://45.157.91.154/static/' . $filename;
                        }


                        $data['time'] = $node->filter('p.match-item-time')->text();
                        $data['BO'] = $node->filter('p.match-item-bo')->text();
                        $data['team1'] = $node->filter('div.home-team > p')->text();
                        $data['team1img'] = $node->filter('div.home-team > img')->attr('src');

                        $filename = substr($data['team1img'], strrpos($data['team1img'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['team1img'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                        }

                        try {
                            $data['score'] = $node->filter('p.match-item-score')->text();
                        } catch (\Exception $exception) {
                            $data['score'] = $node->filter('p.match-item-tag')->text();
                        }
                        $data['team2img'] = $node->filter('div.away-team > img')->attr('src');

                        $filename = substr($data['team2img'], strrpos($data['team2img'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['team2img'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                        }

                        $data['team2'] = $node->filter('div.away-team > p')->text();
                        $data['eventsimg'] = $node->filter('div.leagues > img')->attr('src');
                        $data['events'] = $node->filter('div.leagues > p')->text();

                        $filename = substr($data['eventsimg'], strrpos($data['eventsimg'], '/') + 1);
                        if ($filename == 'csgo_sel_icon.png' || $filename == 'dota_sel_icon.png' || $filename == 'lol_sel_icon.png' || $filename == 'kog_sel_icon.png') {
                            $match_img = DB::table('match')->where('match', $data['events'])
                                ->select('matchimg')
                                ->get()
                                ->toArray();
                            try {
                                $data['eventsimg'] = $match_img[0]->matchimg;
                            } catch (\Exception $exception) {
                                $data['eventsimg'] = 'http://45.157.91.154/static/' . $filename;
                            }
                        } else {
                            if (!file_exists(public_path('static/' . $filename))) {
                                try {
                                    $resp = $client_img->get($data['eventsimg'], ['save_to' => public_path('static/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['eventsimg'] = 'http://45.157.91.154/static/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }

                            } else {
                                $data['eventsimg'] = 'http://45.157.91.154/static/' . $filename;
                            }
                        }


                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'], $data['game']);
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
                                $filename = substr($events['matchimg'], strrpos($events['matchimg'], '/') + 1);
                                if (!file_exists(public_path('static/' . $filename))) {
                                    try {
                                        $resp = $client_img->get($events['matchimg'], ['save_to' => public_path('static/' . $filename)]);
                                        if ($resp->getStatusCode() == 200) {
                                            $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
                                        }
                                    } catch (\Exception $exception) {
                                    }

                                } else {
                                    $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
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
                            $endtime = substr($events['matchtime'], strpos($events['matchtime'], '- ') + 2);
                            $events['timestamp'] = strtotime($endtime);
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在') {
                                $matchspider = new MatchSpiderController();
                                $matchspider->AllMatch($events);
                            }
                        }

                        $data['exponent'] = $node->filter('div.odd')->text();
//                        dd($data);
                        return $data;
                    });
//                    dd($arr);
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
                if (ob_get_level() > 0)
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
                        $data['gameimg'] = 'https://www.500bf.com' . $node->filter('div > div > div.header > img')->attr('src');
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
                        $filename = substr($data['gameimg'], strrpos($data['gameimg'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get('https://www.500bf.com' . $data['gameimg'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['gameimg'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['gameimg'] = 'http://45.157.91.154/static/' . $filename;
                        }

                        $data['events'] = $node->filter('div > div > div.header > p.name')->text();

                        // 获取赛事ID，如赛事不存在，则新增赛事在赛事表中
                        $Match = new Match();
                        $events_id = $Match->GetMatchId($data['events'], $data['game']);
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
                                $filename = substr($events['matchimg'], strrpos($events['matchimg'], '/') + 1);
                                if (!file_exists(public_path('static/' . $filename))) {
                                    try {
                                        $resp = $client_img->get($events['matchimg'], ['save_to' => public_path('static/' . $filename)]);
                                        if ($resp->getStatusCode() == 200) {
                                            $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
                                        }
                                    } catch (\Exception $exception) {
                                    }

                                } else {
                                    $events['matchimg'] = 'http://45.157.91.154/static/' . $filename;
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
                            $endtime = substr($events['matchtime'], strpos($events['matchtime'], '- ') + 2);
                            $events['timestamp'] = strtotime($endtime);
                            $events['link'] = 'https://www.500bf.com' . $events_link;
                            $data['eventsid'] = DB::table('match')->insertGetId($events);
                            if ($events['matchimg'] !== '该赛事内容不存在') {
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
                        } catch (\Exception $exception) {
                            $data['tag4'] = '';
                        }
                        try {
                            $data['tag5'] = $node->filter('div > div > div.header > div > p:nth-child(4)')->text();
                        } catch (\Exception $exception) {
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
                        try {
                            if ($data['game'] == '英雄联盟') {
                                $tv_arr = $node->filter('div > div.header > div.videos-panel.video-panel > ul > li')->each(function ($node2, $i) use ($arr) {
                                    $arr = array_add($arr, $node2->filter('a > span')->text(), 'https://www.500bf.com' . $node2->filter('a')->attr('href'));
                                    return $arr;
                                });
                            } else {
                                $tv_arr = $node->filter('div > div.header > div > div > ul > li')->each(function ($node2, $i) use ($arr) {
                                    $arr = array_add($arr, $node2->filter('a > span')->text(), 'https://www.500bf.com' . $node2->filter('a')->attr('href'));
                                    return $arr;
                                });
                            }
                        } catch (\Exception $exception) {
                            $tv_arr = null;
                        }
                        $data['tv'] = '';
                        try {
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
                        } catch (\Exception $exception) {
                        }


                        $data['now'] = $node->filter('div > div > div.content > div.match-info > p:nth-child(1)')->text();
                        $data['nowtime'] = $node->filter('div > div > div.content > div.match-info > p:nth-child(2)')->text();

                        $data['team1img'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.team > img')->attr('src');

                        $filename = substr($data['team1img'], strrpos($data['team1img'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['team1img'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
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
                            } catch (\Exception $exception) {
                                try {
                                    $data['team1tag3num'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(5) > p')->text();
                                } catch (\Exception $exception) {
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
                            } catch (\Exception $exception) {
                                $data['team1tag3special'] = '';
                            }
                        }
                        if ($data['tag4'] !== '') {
                            try {
                                $data['team1tag4num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.sconde-half > p')->text();
                            } catch (\Exception $exception) {
                                $data['team1tag4num'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(6) > p')->text();
                            }
                        } else {
                            $data['team1tag4num'] = '';
                        }

                        try {
                            $data['team1tag4special'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.sconde-half > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });
                            if (empty($data['team1tag4special'])) {
                                $data['team1tag4special'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(6) > img')->each(function ($node3, $i) {
                                    return 'https://www.500bf.com' . $node3->attr('src');
                                });
                            }
                            if (is_array($data['team1tag4special']))
                                $data['team1tag4special'] = implode("|", $data['team1tag4special']);
                        } catch (\Exception $e) {
                            try {
                                $data['team1tag4special'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(6) > img')->each(function ($node3, $i) {
                                    return 'https://www.500bf.com' . $node3->attr('src');
                                });
                                if (is_array($data['team1tag4special']))
                                    $data['team1tag4special'] = implode("|", $data['team1tag4special']);
                            } catch (\Exception $exception) {
                                $data['team1tag4special'] = '';
                            }
                        }
                        if ($data['tag5'] !== '') {
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
                        if ($data['tag6'] !== '') {
                            $data['team1tag6num'] = $node->filter('div > div.content > div.team-info > div:nth-child(1) > div:nth-child(8)')->text();
                        } else {
                            $data['team1tag6num'] = '';
                        }
                        $data['team1indexnum'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(1) > div.tag.bet > p')->text();


                        $data['team2img'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.team > img')->attr('src');

                        $filename = substr($data['team2img'], strrpos($data['team2img'], '/') + 1);
                        if (!file_exists(public_path('static/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['team2img'], ['save_to' => public_path('static/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }

                        } else {
                            $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
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
                            try {
                                $data['team2tag3num'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(5) > p')->text();
                            } catch (\Exception $exception) {
                                try {
                                    $data['team2tag3num'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(5)')->text();
                                } catch (\Exception $exception) {
                                    $data['team2tag3num'] = '';
                                }
                            }
                        }
                        try {
                            $data['team2tag3special'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.first-half > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });
                            if (empty($data['team2tag3special'])) {
                                $data['team2tag3special'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(5) > img')->each(function ($node3, $i) {
                                    return 'https://www.500bf.com' . $node3->attr('src');
                                });
                            }
                            if (is_array($data['team2tag3special']))
                                $data['team2tag3special'] = implode("|", $data['team2tag3special']);

                        } catch (\Exception $e) {
                            try {#div > div.content > div.team-info > div:nth-child(2) > div:nth-child(5) > img
                                $data['team2tag3special'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(5) > img')->each(function ($node3, $i) {
                                    return 'https://www.500bf.com' . $node3->attr('src');
                                });
                                if (is_array($data['team2tag3special']))
                                    $data['team2tag3special'] = implode("|", $data['team2tag3special']);
                            } catch (\Exception $e) {
                                $data['team2tag3special'] = '';
                            }

                        }
                        if ($data['tag4'] !== '') {
                            try {
                                $data['team2tag4num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.sconde-half > p')->text();
                            } catch (\Exception $e) {
                                $data['team2tag4num'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(6) > p')->text();
                            }
                        } else {
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
                        if ($data['tag5'] !== '') {
                            try {
                                $data['team2tag5num'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.over-time > p')->text();
                            } catch (\Exception $e) {
                                $data['team2tag5num'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(7) > p')->text();
                            }
                        } else {
                            $data['team2tag5num'] = '';
                        }

                        try {
                            $data['team2tag5special'] = $node->filter('div > div > div.content > div.team-info > div:nth-child(2) > div.tag.over-time > img')->each(function ($node3, $i) {
                                return 'https://www.500bf.com' . $node3->attr('src');
                            });#div > div.content > div.team-info > div:nth-child(2) > div:nth-child(7) > img
                            if (empty($data['team2tag5special'])) {
                                $data['team2tag5special'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(7) > img')->each(function ($node3, $i) {
                                    return 'https://www.500bf.com' . $node3->attr('src');
                                });#
                            }
                            if (is_array($data['team2tag5special']))
                                $data['team2tag5special'] = implode("|", $data['team2tag5special']);
                        } catch (\Exception $e) {
                            try {
                                $data['team2tag5special'] = $node->filter('div > div.content > div.team-info > div:nth-child(2) > div:nth-child(7) > img')->each(function ($node3, $i) {
                                    return 'https://www.500bf.com' . $node3->attr('src');
                                });#
                                if (is_array($data['team2tag5special']))
                                    $data['team2tag5special'] = implode("|", $data['team2tag5special']);
                            } catch (\Exception $e) {
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


    public function TVPagMatchDetails($match_id = 1)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $this->url[] = 'https://500bf.com/index/index/living_bat?type=1&match_id=268076395&tab_index=6&map_index=1';
//        $this->url[] = 'https://500bf.com/index/index/living_bat?type=1&match_id=268076395&tab_index=1&map_index=1';
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
                if (ob_get_level() > 0)
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
                    $client_img = new Client(['verify' => false]);
                    $data['matchid'] = '268076395';
                    $team1img = $crawler->filter('body > div > div.bat-data > div:nth-child(1) > div.bat-info0 > div.home > img')->attr('src');
                    $filename = substr($team1img, strrpos($team1img, '/') + 1);
                    if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                        try {
                            $resp = $client_img->get($team1img, ['save_to' => public_path('static/matchdetails/' . $filename)]);
                            if ($resp->getStatusCode() == 200) {
                                $data['team1img'] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                            }
                        } catch (\Exception $exception) {
                        }

                    } else {
                        $data['team1img'] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                    }

                    $data['team1'] = $crawler->filter('body > div > div.bat-data > div:nth-child(1) > div.bat-info0 > div.home > span')->text();
                    $data['team1special'] = $crawler->filter('body > div > div.bat-data > div:nth-child(1) > div.bat-info0 > div.icons > img')->each(function ($node, $i) {
                        return 'https://500bf.com' . $node->attr('src');
                    });
                    if (is_array($data['team1special'])) {
                        foreach ($data['team1special'] as $key => $item) {
                            $filename = substr($item, strrpos($item, '/') + 1);
                            if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                                try {
                                    $resp = $client_img->get($item, ['save_to' => public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team1special'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }

                            } else {
                                $data['team1special'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                            }
                        }
                        $data['team1special'] = implode('|', $data['team1special']);
                    }
                    $data['team1score'] = $crawler->filter('body > div > div.bat-data > div:nth-child(1) > div.bat-info0 > span')->text();
                    $data['team1tags'] = $crawler->filter('body > div > div.bat-data > div:nth-child(1) > div.bat-info1 > div > div')->each(function ($node, $i) {
                        $array['img'] = 'https://500bf.com' . $node->filter('img')->attr('src');
                        $array['num'] = $node->filter('span')->text();
                        return $array;
                    });
                    if (is_array($data['team1tags'])) {
                        foreach ($data['team1tags'] as $key => $item) {
                            $filename = substr($item['img'], strrpos($item['img'], '/') + 1);
                            if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                                try {
                                    $resp = $client_img->get($item['img'], ['save_to' => public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team1tags'][$key]['img'] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }
                            } else {
                                $data['team1tags'][$key]['img'] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                            }
                            $data['team1tags'][$key] = implode('^', $item);
                        }
                        $data['team1tags'] = implode('|', $data['team1tags']);
                    }

                    $data['team1ban'] = $crawler->filter('body > div > div.bat-data > div:nth-child(1) > div.ban.img-right > img')->each(function ($node, $i) {
                        return $node->attr('src');
                    });

                    if (is_array($data['team1ban'])) {
                        foreach ($data['team1ban'] as $key => $datum) {
                            $filename = substr($datum, strrpos($datum, '/') + 1);
                            if (!file_exists(public_path('static/matchdetails' . $filename))) {
                                try {
                                    $resp = $client_img->get($datum, ['save_to' => public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team1ban'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }
                            } else {
                                $data['team1ban'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                            }
                        }
                        $data['team1ban'] = implode('|', $data['team1ban']);
                    }

                    $data['team1pick'] = $crawler->filter('body > div > div.bat-data > div:nth-child(1) > div.pick.img-right > img')->each(function ($node, $i) {
                        return $node->attr('src');
                    });
                    if (is_array($data['team1pick'])) {
                        foreach ($data['team1pick'] as $key => $datum) {
                            $filename = substr($datum, strrpos($datum, '/') + 1);
                            if (!file_exists(public_path('static/matchdetails' . $filename))) {
                                try {
                                    $resp = $client_img->get($datum, ['save_to' => public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team1pick'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }
                            } else {
                                $data['team1pick'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                            }
                        }
                        $data['team1pick'] = implode('|', $data['team1pick']);
                    }

                    $data['status'] = $crawler->filter('body > div > div.bat-data > div.center-panel > div > span:nth-child(1)')->text();
                    $data['matchtime'] = $crawler->filter('body > div > div.bat-data > div.center-panel > div > span:nth-child(2)')->text();
                    $data['team2score'] = $crawler->filter('body > div > div.bat-data > div:nth-child(3) > div.bat-info0 > span')->text();
                    $data['team2special'] = $crawler->filter('body > div > div.bat-data > div:nth-child(3) > div.bat-info0 > div.icons > img')->each(function ($node, $i) {
                        return 'https://500bf.com' . $node->attr('src');
                    });
                    if (is_array($data['team2special'])) {
                        foreach ($data['team2special'] as $key => $datum) {
                            $filename = substr($datum, strrpos($datum, '/') + 1);
                            if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                                try {
                                    $resp = $client_img->get($datum, ['save_to' => public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team2special'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }
                            } else {
                                $data['team2special'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                            }
                        }
                        $data['team2special'] = implode('|', $data['team2special']);
                    }
                    $data['team2'] = $crawler->filter('body > div > div.bat-data > div:nth-child(3) > div.bat-info0 > div.home > span')->text();
                    $data['team2img'] = $crawler->filter('body > div > div.bat-data > div:nth-child(3) > div.bat-info0 > div.home > img')->attr('src');
                    try {
                        $filename = substr($data['team2img'], strrpos($data['team2img'], '/') + 1);
                        if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                            try {
                                $resp = $client_img->get($data['team2img'], ['save_to' => public_path('static/matchdetails/' . $filename)]);
                                if ($resp->getStatusCode() == 200) {
                                    $data['team2img'] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                                }
                            } catch (\Exception $exception) {
                            }
                        } else {
                            $data['team2img'] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                        }

                    } catch (\Exception $exception) {
                    }

                    $data['team2tags'] = $crawler->filter('body > div > div.bat-data > div:nth-child(3) > div.bat-info1 > div > div')->each(function ($node, $i) {
                        $array['img'] = 'https://500bf.com' . $node->filter('img')->attr('src');
                        $array['num'] = $node->filter('span')->text();
                        return $array;
                    });
                    if (is_array($data['team2tags'])) {
                        foreach ($data['team2tags'] as $key => $teamtag) {
                            $filename = substr($teamtag['img'], strrpos($teamtag['img'], '/') + 1);
                            if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                                try {
                                    $resp = $client_img->get($teamtag, ['save_to' => public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team2tags'][$key]['img'] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }
                            } else {
                                $data['team2tags'][$key]['img'] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                            }
                            $data['team2tags'][$key] = implode('^', $teamtag);
                        }
                        $data['team2tags'] = implode('|', $data['team2tags']);
                    }

                    $data['team2ban'] = $crawler->filter('body > div > div.bat-data > div:nth-child(3) > div.ban.img-left > img')->each(function ($node, $i) {
                        return $node->attr('src');
                    });
                    if (is_array($data['team2ban'])) {
                        foreach ($data['team2ban'] as $key => $item) {
                            $filename = substr($item, strrpos($item, '/') + 1);
                            if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                                try {
                                    $resp = $client_img->get($item, ['save_to', public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team2ban'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }
                            } else {
                                $data['team2ban'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                            }
                        }
                        $data['team2ban'] = implode('|', $data['team2ban']);
                    }

                    $data['team2pick'] = $crawler->filter('body > div > div.bat-data > div:nth-child(3) > div.pick.img-left > img')->each(function ($node, $i) {
                        return $node->attr('src');
                    });

                    if (is_array($data['team2pick'])) {
                        foreach ($data['team2pick'] as $key => $item) {
                            $filename = substr($item, strrpos($item, '/') + 1);
                            if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                                try {
                                    $resp = $client_img->get($item, ['save_to', public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['team2pick'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                                    }
                                } catch (\Exception $exception) {
                                }
                            } else {
                                $data['team2pick'][$key] = 'http://45.157.91.154/static/matchdetails/' . $filename;
                            }
                        }
                        $data['team2pick'] = implode('|', $data['team2pick']);
                    }

                    $data['team1camp'] = $crawler->filter('body > div > div.bat-players > div:nth-child(1) > div.header > div.tag > p')->text();
                    $data['camp1tag1'] = $crawler->filter('body > div > div.bat-players > div:nth-child(1) > div.header > div.other > p:nth-child(1)')->text();
                    $data['camp1tag2'] = $crawler->filter('body > div > div.bat-players > div:nth-child(1) > div.header > div.other > p:nth-child(2)')->text();
                    $data['camp1tag3'] = $crawler->filter('body > div > div.bat-players > div:nth-child(1) > div.header > div.other > p:nth-child(3)')->text();
                    $data['camp1tag4'] = $crawler->filter('body > div > div.bat-players > div:nth-child(1) > div.header > div.other > p:nth-child(4)')->text();
                    $data['camp1tag5'] = $crawler->filter('body > div > div.bat-players > div:nth-child(1) > div.header > div.other > p:nth-child(5)')->text();
                    $data['camp1tag6'] = $crawler->filter('body > div > div.bat-players > div:nth-child(1) > div.header > div.other > p:nth-child(6)')->text();
                    $data['camp1tag7'] = $crawler->filter('body > div > div.bat-players > div:nth-child(1) > div.header > div.other > p:nth-child(7)')->text();

                    $camp1hero = $crawler->filter('body > div > div.bat-players > div:nth-child(1) > div.table-players > div')->each(function ($node, $i) {
                        $array['heroimg'] = $node->filter('div.info > img')->attr('src');
                        $array['heroname'] = $node->filter('div.info > span')->text();
                        $array['tag1'] = $node->filter('div.info-panel > span:nth-child(1)')->text();
                        $array['tag2'] = $node->filter('div.info-panel > span:nth-child(2)')->text();
                        $array['tag3'] = $node->filter('div.info-panel > span:nth-child(3)')->text();
                        $array['tag4'] = $node->filter('div.info-panel > span:nth-child(4)')->text();
                        $array['tag5'] = $node->filter('div.info-panel > span:nth-child(5)')->text();
                        $array['tag6'] = $node->filter('div.info-panel > span:nth-child(6)')->text();
                        $array['equipment'] = $node->filter('div.info-panel > div > div > img')->each(function ($img_node, $i) {
                            return $img_node->attr('src');
                        });
                        return $array;
                    });

                    foreach ($camp1hero as $heronum => $camp) {
                        $heronum = $heronum + 1;
                        if (count($camp) > 0) {
                            $filename = substr($camp['heroimg'], strrpos($camp['heroimg'], '/') + 1);
                            if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                                try {
                                    $resp = $client_img->get($camp['heroimg'], ['save_to' => public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['camp1hero' . $heronum] = 'http://45.157.91.154/static/matchdetails/' . $filename . '|' . $camp['heroname'] . '|'
                                            . $camp['tag1'] . '|' . $camp['tag2'] . '|' . $camp['tag3'] . '|' . $camp['tag4'] . '|' . $camp['tag5'] . '|' . $camp['tag6'];
                                    } else {
                                        $data['camp1hero' . $heronum] = $camp['heroimg'] . '|' . $camp['heroname'] . '|'
                                            . $camp['tag1'] . '|' . $camp['tag2'] . '|' . $camp['tag3'] . '|' . $camp['tag4'] . '|' . $camp['tag5'] . '|' . $camp['tag6'];
                                    }

                                } catch (\Exception $exception) {
                                    $data['camp1hero' . $heronum] = $camp['heroimg'] . '|' . $camp['heroname'] . '|'
                                        . $camp['tag1'] . '|' . $camp['tag2'] . '|' . $camp['tag3'] . '|' . $camp['tag4'] . '|' . $camp['tag5'] . '|' . $camp['tag6'];
                                }
                            } else {
                                $data['camp1hero' . $heronum] = 'http://45.157.91.154/static/matchdetails/' . $filename . '|' . $camp['heroname'] . '|'
                                    . $camp['tag1'] . '|' . $camp['tag2'] . '|' . $camp['tag3'] . '|' . $camp['tag4'] . '|' . $camp['tag5'] . '|' . $camp['tag6'];;
                            }
                            $data['camp1hero' . $heronum . 'equipment'] = '';
                            foreach ($camp['equipment'] as $key => $equipment) {
                                $equipment_name = substr($equipment, strrpos($equipment, '/') + 1);
                                if (!file_exists(public_path('static/matchdetails/' . $equipment_name))) {
                                    try {
                                        $resp = $client_img->get($equipment, ['save_to' => public_path('static/matchdetails/' . $equipment_name)]);
                                        if ($resp->getStatusCode() == 200) {
                                            $data['camp1hero' . $heronum . 'equipment'] = $data['camp1hero' . $heronum . 'equipment'] . 'http://45.157.91.154/static/matchdetails/' . $equipment_name;
                                        } else {
                                            $data['camp1hero' . $heronum . 'equipment'] = $equipment;
                                        }
                                    } catch (\Exception $exception) {
                                        $data['camp1hero' . $heronum . 'equipment'] = $equipment;
                                    }

                                } else {
                                    $data['camp1hero' . $heronum . 'equipment'] = $data['camp1hero' . $heronum . 'equipment'] . 'http://45.157.91.154/static/matchdetails/' . $equipment_name;
                                }
                                if ($key < count($camp['equipment']) - 1)
                                    $data['camp1hero' . $heronum . 'equipment'] = $data['camp1hero' . $heronum . 'equipment'] . '|';
                            }
                        }
                    }

                    $data['team2camp'] = $crawler->filter('body > div > div.bat-players > div:nth-child(2) > div.header > div.tag > p')->text();
                    $data['camp2tag1'] = $crawler->filter('body > div > div.bat-players > div:nth-child(2) > div.header > div.other > p:nth-child(1)')->text();
                    $data['camp2tag2'] = $crawler->filter('body > div > div.bat-players > div:nth-child(2) > div.header > div.other > p:nth-child(2)')->text();
                    $data['camp2tag3'] = $crawler->filter('body > div > div.bat-players > div:nth-child(2) > div.header > div.other > p:nth-child(3)')->text();
                    $data['camp2tag4'] = $crawler->filter('body > div > div.bat-players > div:nth-child(2) > div.header > div.other > p:nth-child(4)')->text();
                    $data['camp2tag5'] = $crawler->filter('body > div > div.bat-players > div:nth-child(2) > div.header > div.other > p:nth-child(5)')->text();
                    $data['camp2tag6'] = $crawler->filter('body > div > div.bat-players > div:nth-child(2) > div.header > div.other > p:nth-child(6)')->text();
                    $data['camp2tag7'] = $crawler->filter('body > div > div.bat-players > div:nth-child(2) > div.header > div.other > p:nth-child(7)')->text();

                    $camp2hero = $crawler->filter('body > div > div.bat-players > div:nth-child(2) > div.table-players > div')->each(function ($node, $i) {
                        $array['heroimg'] = $node->filter('div.info > img')->attr('src');
                        $array['heroname'] = $node->filter('div.info > span')->text();
                        $array['tag1'] = $node->filter('div.info-panel > span:nth-child(1)')->text();
                        $array['tag2'] = $node->filter('div.info-panel > span:nth-child(2)')->text();
                        $array['tag3'] = $node->filter('div.info-panel > span:nth-child(3)')->text();
                        $array['tag4'] = $node->filter('div.info-panel > span:nth-child(4)')->text();
                        $array['tag5'] = $node->filter('div.info-panel > span:nth-child(5)')->text();
                        $array['tag6'] = $node->filter('div.info-panel > span:nth-child(6)')->text();
                        $array['equipment'] = $node->filter('div.info-panel > div > img')->each(function ($img_node, $i) {
                            return $img_node->attr('src');
                        });
                        return $array;
                    });

                    foreach ($camp2hero as $heronum => $camp) {
                        $heronum = $heronum + 1;
                        if (count($camp) > 0) {
                            $filename = substr($camp['heroimg'], strrpos($camp['heroimg'], '/') + 1);
                            if (!file_exists(public_path('static/matchdetails/' . $filename))) {
                                try {
                                    $resp = $client_img->get($camp['heroimg'], ['save_to' => public_path('static/matchdetails/' . $filename)]);
                                    if ($resp->getStatusCode() == 200) {
                                        $data['camp2hero' . $heronum] = 'http://45.157.91.154/static/matchdetails/' . $filename . '|' . $camp['heroname'] . '|'
                                            . $camp['tag1'] . '|' . $camp['tag2'] . '|' . $camp['tag3'] . '|' . $camp['tag4'] . '|' . $camp['tag5'] . '|' . $camp['tag6'];
                                    } else {
                                        $data['camp2hero' . $heronum] = $camp['heroimg'] . '|' . $camp['heroname'] . '|'
                                            . $camp['tag1'] . '|' . $camp['tag2'] . '|' . $camp['tag3'] . '|' . $camp['tag4'] . '|' . $camp['tag5'] . '|' . $camp['tag6'];;
                                    }

                                } catch (\Exception $exception) {
                                    $data['camp2hero' . $heronum] = $camp['heroimg'] . '|' . $camp['heroname'] . '|'
                                        . $camp['tag1'] . '|' . $camp['tag2'] . '|' . $camp['tag3'] . '|' . $camp['tag4'] . '|' . $camp['tag5'] . '|' . $camp['tag6'];;
                                }
                            } else {
                                $data['camp2hero' . $heronum] = 'http://45.157.91.154/static/matchdetails/' . $filename . '|' . $camp['heroname'] . '|'
                                    . $camp['tag1'] . '|' . $camp['tag2'] . '|' . $camp['tag3'] . '|' . $camp['tag4'] . '|' . $camp['tag5'] . '|' . $camp['tag6'];;
                            }
                            $data['camp2hero' . $heronum . 'equipment'] = '';
                            foreach ($camp['equipment'] as $key => $equipment) {
                                echo "2<br>";
                                $equipment_name = substr($equipment, strrpos($equipment, '/') + 1);
                                if (!file_exists(public_path('static/matchdetails/' . $equipment_name))) {
                                    try {
                                        $resp = $client_img->get($equipment, ['save_to' => public_path('static/matchdetails/' . $equipment_name)]);
                                        if ($resp->getStatusCode() == 200) {
                                            $data['camp2hero' . $heronum . 'equipment'] = $data['camp2hero' . $heronum . 'equipment'] . 'http://45.157.91.154/static/matchdetails/' . $equipment_name;
                                        } else {
                                            $data['camp2hero' . $heronum . 'equipment'] = $equipment;
                                        }

                                    } catch (\Exception $exception) {
                                        $data['camp2hero' . $heronum . 'equipment'] = $equipment;
                                    }

                                } else {
                                    $data['camp2hero' . $heronum . 'equipment'] = $data['camp2hero' . $heronum . 'equipment'] . 'http://45.157.91.154/static/matchdetails/' . $equipment_name;
                                }
                                if ($key < count($camp['equipment']) - 1)
                                    $data['camp2hero' . $heronum . 'equipment'] = $data['camp2hero' . $heronum . 'equipment'] . '|';
                                echo "3<br>";
                            }
                        }
                    }

//                    dd($camp1hero1);
                    dd($data);

//                    dd($arr);
//                    DB::table('scoreing')->truncate();
//                    DB::table('scoreing')->insert($arr);


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

    public function demo()
    {
        try {
            $this->TVPagMatchDetails();

        } catch (\Exception $exception) {
            dd(123);
        }
    }
}
