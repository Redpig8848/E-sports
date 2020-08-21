<?php

namespace App\Http\Controllers;

use App\Match;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class InformationSpiderController extends Controller
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



    function lol(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
//        for ($i = 10; $i >= 1; $i--) {
            $this->url = ['https://lol.dianjinghu.com/news/p/all/1.html'];
//            $this->url[] = 'https://lol.dianjinghu.com/news/p/all/'.$i.'.html';
//        }
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
                    $arr = $crawler->filter('body > div.part-one > div.container.oh.pb100 > div.list-left.article-left > a')->each(function ($node, $i) use ($http) {
                        $data['thumbnail'] = $node->filter('img')->attr('src');
                        $client_img = new Client(['verify' => false]);
                        $filename = substr($data['thumbnail'],strrpos($data['thumbnail'],'/')+1);
                        if (!file_exists(public_path('static/information/'.$filename))){
                            try {
                                $client_img->get('https://lol.dianjinghu.com'.$data['thumbnail'],['save_to' => public_path('static/information/'.$filename)]);
                                $data['thumbnail'] = 'http://45.157.91.154/static/information/'.$filename;
                            }catch (\Exception $exception){
                                $data['thumbnail'] = '';
                            }

                        }else{
                            $data['thumbnail'] = 'http://45.157.91.154/static/information/'.$filename;
                        }
                        $data['title'] = trim($node->filter('div > h4')->text());
                        $num = DB::table('information')->where('title',$data['title'])->count();
                        if ($num > 0){
//                            echo 222;
                            exit();
                        }
                        $data['gametype'] = '英雄联盟';
                        $data['gametypeid'] = 3;



                        $href = $node->attr('href');

                        $href_client = new Client(['verify' => false]);
                        try {
                            $href_http = $href_client->get('https://lol.dianjinghu.com'.$href)->getBody()->getContents();
                            $data['time'] = $this->time($href_http);
                            $unix = str_replace(array('年','月'),'-',$data['time']);
                            $data['unix'] = strtotime(str_replace('日','',$unix));
                            $data['body'] = $this->body($href_http);
                            $bool = DB::table('information')->insert($data);
                            echo $bool."<br>";
                        }catch (\Exception $exception){
                            echo '错误，跳过<br>';
                        }

                    });
//                    dd($arr);
//                    echo "111<br>";
//                    $bool = DB::table('information')->insert($arr);

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


    function dota(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
//        for ($i = 10; $i >= 1; $i--) {
//            $this->url[] = 'http://dota2.dianjinghu.com/news/p/all/'.$i.'.html';
//            $this->url = ['http://dota2.dianjinghu.com/news/p/all/1.html'];
            $this->url = ['https://www.dota2.com.cn/news/index1.htm'];
//        }
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
                    $arr = $crawler->filter('#news_lists > ul.panes > li.pane.active > a')->each(function ($node, $i) use ($http) {
                        $data['thumbnail'] = $node->filter('div.news_logo > img')->attr('src');
                        $client_img = new Client(['verify' => false]);
                        $filename = substr($data['thumbnail'],strrpos($data['thumbnail'],'/')+1);
                        if (!file_exists(public_path('static/information/'.$filename))){
                            try {
                                $client_img->get($data['thumbnail'],['save_to' => public_path('static/information/'.$filename)]);
                                $data['thumbnail'] = 'http://45.157.91.154/static/information/'.$filename;
                            }catch (\Exception $exception){
                                $data['thumbnail'] = '';
                            }

                        }else{
                            $data['thumbnail'] = 'http://45.157.91.154/static/information/'.$filename;
                        }
                        $data['title'] = trim($node->filter('div.news_msg > h2')->text());
                        $num = DB::table('information')->where('title',$data['title'])->count();
                        if ($num > 0){
//                            echo 222;
                            exit();
                        }
                        $data['gametype'] = 'DOTA2';
                        $data['gametypeid'] = 1;



                        $href = $node->attr('href');


                        try {
                            $href_client = new Client(['verify' => false]);
                            $crawler_2 = new Crawler();
                            $href_http = $href_client->get($href)->getBody()->getContents();
//                            dd($href_http);
                            $crawler_2->addHtmlContent($href_http);
                            $time = $crawler_2->filter('body > div.wrapper > div > div.main.clearfix > div.news > div.news_main > div.title > h3')->text();
                            $regex="'\d{4}-\d{1,2}-\d{1,2}'is";
                            preg_match($regex,$time,$time);
//                            $time = $crawler_2->filter('#news_detail > div.article-top > div.c-title > p')->text();
                            $data['time'] = $time[0];
                            $data['unix'] = strtotime($data['time']);
                            $data['body'] = $crawler_2->filter('body > div.wrapper > div > div.main.clearfix > div.news > div.news_main > div.content')->html();
                            $no_need = $crawler_2->filter('body > div.wrapper > div > div.main.clearfix > div.news > div.news_main > div.content > div')->html();
                            $data['body'] = str_replace($no_need,'',$data['body']);
                            $bool = DB::table('information')->insert($data);
                            echo $bool."<br>";
                        }catch (\Exception $exception){
                            echo '错误，跳过<br>';
                        }

                    });
//                    dd($arr);
//                    echo "111<br>";
//                    $bool = DB::table('information')->insert($arr);

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

    function gok(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
//        for ($i = 10; $i >= 1; $i--) {
//            $this->url[] = 'http://pvp.dianjinghu.com/news/p/all/'.$i.'.html';
        $this->url = ['http://pvp.dianjinghu.com/news/p/all/1.html'];
//        }
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
                    $arr = $crawler->filter('body > div.container.oh.pb100 > div.list-left.article-left > a')->each(function ($node, $i) use ($http) {
                        $data['thumbnail'] = $node->filter('img')->attr('data-original');
                        $client_img = new Client(['verify' => false]);
                        $filename = substr($data['thumbnail'],strrpos($data['thumbnail'],'/')+1);
                        if (!file_exists(public_path('static/information/'.$filename))){
                            try {
                                $client_img->get($data['thumbnail'],['save_to' => public_path('static/information/'.$filename)]);
                                $data['thumbnail'] = 'http://45.157.91.154/static/information/'.$filename;
                            }catch (\Exception $exception){
                                $data['thumbnail'] = '';
                            }

                        }else{
                            $data['thumbnail'] = 'http://45.157.91.154/static/information/'.$filename;
                        }
                        $data['title'] = trim($node->filter('div > h4')->text());
                        $num = DB::table('information')->where('title',$data['title'])->count();
                        if ($num > 0){
//                            echo 222;
                            exit();
                        }
                        $data['gametype'] = '王者荣耀';
                        $data['gametypeid'] = 4;



                        $href = $node->attr('href');


                        try {
                            $href_client = new Client(['verify' => false]);
                            $crawler_2 = new Crawler();
                            $href_http = $href_client->get('http://pvp.dianjinghu.com'.$href)->getBody()->getContents();
                            $crawler_2->addHtmlContent($href_http);
                            $time = $crawler_2->filter('#news_detail > div.article-top > div.c-title > p')->text();
                            $data['time'] = trim(substr($time,0,strpos($time,'日')+9));
                            $unix = str_replace(array('年','月'),'-',$data['time']);
                            $data['unix'] = strtotime(str_replace('日','',$unix));
                            $data['body'] = $crawler_2->filter('#news_detail > div.article-top > div.new_conts')->html();
                            $bool = DB::table('information')->insert($data);
                            echo $bool."<br>";
                        }catch (\Exception $exception){
                            echo '错误，跳过<br>';
                        }

                    });
//                    dd($arr);
//                    echo "111<br>";
//                    $bool = DB::table('information')->insert($arr);

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



    function cs(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
//        for ($i = 1; $i >= 1; $i--) {
//            $this->url[] = 'https://www.csgo.com.cn/news/gameevent/index'.$i.'.html';
        $this->url = ['https://www.csgo.com.cn/news/index1.html'];
//        }
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
                    $arr = $crawler->filter('body > div.bg.bg_news > div > div.con_left > div > div.list_con > ul > li')->each(function ($node, $i) use ($http) {
                        $data['thumbnail'] = $node->filter('a > img')->attr('src');
                        $client_img = new Client(['verify' => false]);
                        $filename = substr($data['thumbnail'],strrpos($data['thumbnail'],'/')+1);
                        if (!file_exists(public_path('static/information/'.$filename))){
                            try {
                                $client_img->get($data['thumbnail'],['save_to' => public_path('static/information/'.$filename)]);
                                $data['thumbnail'] = 'http://45.157.91.154/static/information/'.$filename;
                            }catch (\Exception $exception){
                                $data['thumbnail'] = '';
                            }

                        }else{
                            $data['thumbnail'] = 'http://45.157.91.154/static/information/'.$filename;
                        }
                        $data['title'] = trim($node->filter('div > h3')->text());
                        $num = DB::table('information')->where('title',$data['title'])->count();
                        if ($num > 0){
//                            echo 222;
                            exit();
                        }
                        $data['gametype'] = 'CS:GO';
                        $data['gametypeid'] = 2;



                        $href = $node->filter('div > a')->attr('href');


                        try {
                            $href_client = new Client(['verify' => false]);
                            $crawler_2 = new Crawler();
                            $href_http = $href_client->get($href)->getBody()->getContents();
                            $crawler_2->addHtmlContent($href_http);
                            $time = $crawler_2->filter('body > div.bg > div.container > div.con_left > div.artical > div.sub_tit > div > span:nth-child(2)')->text();
                            $data['time'] = str_replace('时间：','',$time);
                            $data['unix'] = strtotime($data['time']);
                            $data['body'] = $crawler_2->filter('body > div.bg > div.container > div.con_left > div.artical > div.wen.fontStyle')->html();
                            $bool = DB::table('information')->insert($data);
                            echo $bool."<br>";
                        }catch (\Exception $exception){
                            echo '错误，跳过<br>';
                        }

                    });
//                    dd($arr);
//                    echo "111<br>";
//                    $bool = DB::table('information')->insert($arr);

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
























    function time($html){
        $time = substr($html,strpos($html,"<p class=\"time\">")+16);
        $time = substr($time,0,strpos($time,'&nbsp;'));
        return $time;
    }

    function body($html){
        $body = substr($html,strpos($html,"<div class=\"new_conts\">"));
        $body = substr($body,0,strrpos($body,'<div id="adv_bd_2"'));
        return $body;
    }















}
