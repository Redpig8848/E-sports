<?php

namespace App\Http\Controllers;

use App\Match;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class MatchSpiderController extends Controller
{
    //
    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 30;  // 同时并发抓取

    protected $startUrl = 'https://www.autotimes.com.cn/news/1.html';

    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount) {
            return;
        }
    }


    function AllMatch($links = '')
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $this->totalPageCount = 1500;
        $client = new Client();
        if ($links == '') {
            $now = strtotime(date('Y-m-d')) - 86400;
//            $this->url = DB::table('match')->where('timestamp', '>', $now)->orWhere('timestamp','==',0)->get()->toArray();
            $this->url = DB::table('match')->get()->toArray();
//            DB::table('schedulematch')->truncate();
        } else {
            $this->url = $links['link'];
        }
        $fn = new FnscoreSpiderController();
        if (is_string($this->url)) {

            $requests = function ($total) use ($client, $links, $fn) {
                $uri = $this->url;
                yield function () use ($client, $uri, $links, $fn) {
                    if ($links == '') {
                        if ($uri->matchimg != "该赛事内容不存在") {
                            if (strpos($uri->link, 'fnscore') !== false) {
                                $datas = array_filter($fn->FnScoreLeague($uri->link, $uri->match, $uri->id));
                                DB::table('schedulematch')->where('eventid',$uri->id)->delete();
                                DB::table('schedulematch')->insert($datas);
//                                foreach ($datas as $data) {
//                                    DB::table('schedulematch')->updateOrInsert(
//                                        ['event' => $data['event'], 'eventid' => $data['eventid'], 'time' => $data['time'], 'team1img' => $data['team1img'],
//                                            'team1' => $data['team1'], 'team2img' => $data['team2img'], 'team2' => $data['team2'], 'BO' => $data['BO']
//                                        ],
//                                        ['score' => $data['score']]
//                                    );
//                                }
                            } else {
                                return $client->get($uri->link, ['verify' => false]);
                            }


                        }
                    } else {
                        return $client->get($uri, ['verify' => false]);
                    }
                };
            };
        }
        else {
            $requests = function ($total) use ($client, $links, $fn) {
                foreach ($this->url as $uri) {
                    yield function () use ($client, $uri, $links, $fn) {
                        if ($links == '') {
                            if ($uri->matchimg != "该赛事内容不存在") {
                                if (strpos($uri->link, 'fnscore') !== false) {
                                    $datas = array_filter($fn->FnScoreLeague($uri->link, $uri->match, $uri->id));
                                    DB::table('schedulematch')->where('eventid',$uri->id)->delete();
                                    print_r($datas);
                                    echo "fnsocre<br>";
                                    DB::table('schedulematch')->insert($datas);
//                                    foreach ($datas as $data) {
//                                        DB::table('schedulematch')->updateOrInsert(
//                                            ['event' => $data['event'], 'eventid' => $data['eventid'], 'time' => $data['time'], 'team1img' => $data['team1img'],
//                                                'team1' => $data['team1'], 'team2img' => $data['team2img'], 'team2' => $data['team2'], 'BO' => $data['BO']
//                                            ],
//                                            ['score' => $data['score']]
//                                        );
//                                    }
                                } else {
                                    return $client->get($uri->link, ['verify' => false]);
                                }
                            }
                        } else {
                            return $client->get($uri, ['verify' => false]);
                        }
                    };
                }
            };
        }

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) use ($links) {
//                echo '爬取' . $this->url[$index];
                echo '<br>';
                if (ob_get_level() > 0)
                    ob_flush();
                flush();
                try {
//                    dd($response->getBody()->getContents());
                    if (!is_null($response))
                        $http = $response->getBody()->getContents();
//                    $http = iconv('gbk', 'UTF-8', $response->getBody()->getContents());
                } catch (\Exception $e) {
                    echo '没有找到数据';
                }
                if (!empty($http)) {
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($http);
                    $arr = $crawler->filter('#__layout > div.body > div.detail-wrapper.default-continer > div.detail-container > div > div.match-panel-container > div.match-panel-item')->each(function ($node, $i) use ($http, $index, $links) {
                        try {
                            $data['event'] = $this->url[$index]->match;
                            $data['eventid'] = $this->url[$index]->id;
                        } catch (\Exception $exception) {
                            $data['event'] = $links['match'];
                            $data['eventid'] = $links['matchid'];
                        }
                        $data['time'] = $node->filter('p:nth-child(1)')->text();
                        $data['team1img'] = $node->filter('div:nth-child(2) > img')->attr('src');
                        $client_img = new Client(['verify' => false]);
                        $filename = substr($data['team1img'], strrpos($data['team1img'], '/') + 1);
                        if (strpos($data['team1img'], '/lol/team.png') !== false) {
                            $data['team1img'] = 'http://45.157.91.154/static/lolteam.png';
                        } elseif (strpos($data['team1img'],'/dota/team.png')){
                            $data['team1img'] = 'http://45.157.91.154/static/dotateam.png';
                        } elseif (strpos($data['team1img'],'/kog/team.png')){
                            $data['team1img'] = 'http://45.157.91.154/static/kogteam.png';
                        } else {
                            if (!file_exists(public_path('static/' . $filename))) {
                                try {
                                    $client_img->get($data['team1img'], ['save_to' => public_path('static/' . $filename)]);
                                    $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                                } catch (\Exception $exception) {
                                    $data['team1img'] = '';
                                }

                            } else {
                                $data['team1img'] = 'http://45.157.91.154/static/' . $filename;
                            }
                        }
//                        dd($data);
                        $data['team1'] = $node->filter('div:nth-child(2) > p')->text();
                        $data['score'] = $node->filter('p.score')->text();
                        $data['team2img'] = $node->filter('div:nth-child(4) > img')->attr('src');

                        $filename = substr($data['team2img'], strrpos($data['team2img'], '/') + 1);

                        if (strpos($data['team2img'],'/lol/team.png') !== false) {
                            $data['team2img'] = 'http://45.157.91.154/static/lolteam.png';
                        } elseif (strpos($data['team2img'],'/dota/team.png')){
                            $data['team2img'] = 'http://45.157.91.154/static/dotateam.png';
                        } elseif (strpos($data['team2img'],'/kog/team.png')){
                            $data['team2img'] = 'http://45.157.91.154/static/kogteam.png';
                        } else {
                            if (!file_exists(public_path('static/' . $filename))) {
                                try {
                                    $client_img->get($data['team2img'], ['save_to' => public_path('static/' . $filename)]);
                                    $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                                } catch (\Exception $exception) {
                                    $data['team2img'] = '';
                                }

                            } else {
                                $data['team2img'] = 'http://45.157.91.154/static/' . $filename;
                            }
                        }



                        $data['team2'] = $node->filter('div:nth-child(4) > p')->text();
                        $data['BO'] = $node->filter('p:nth-child(5)')->text();
//                        $endtime = substr($data['time'],strpos($data['time'],'- ')+2);
//                        $data['timestamp'] = strtotime($endtime);
//                        DB::table('schedulematch')->updateOrInsert(
//                            ['event' => $data['event'], 'eventid' => $data['eventid'], 'time' => $data['time'], 'team1img' => $data['team1img'],
//                                'team1' => $data['team1'], 'team2img' => $data['team2img'], 'team2' => $data['team2'], 'BO' => $data['BO']
//                            ],
//                            ['score' => $data['score']]
//                        );
//                        if($data['eventid'] == '473' || $data['eventid'] == 473){
//                            $data;
//                        }
                        return $data;
//                        dd($data);

                    });
                    DB::table('schedulematch')->where('eventid',$arr[0]['eventid'])->delete();
                    DB::table('schedulematch')->insert($arr);

//                    print_r($arr);
//                    echo "500bf<br>";


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
