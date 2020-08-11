<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class DemoController extends Controller
{
    //
    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 300;  // 同时并发抓取

    protected $startUrl = 'https://www.autotimes.com.cn/news/1.html';

    // 首页正在进行全部游戏
    public function index()
    {

         dd(file_get_contents('https://www.fnscore.com/'));


        set_time_limit(0);
        ini_set('memory_limit', '-1');
        for ($i = 1; $i < 2; $i++) {
            $this->url[] = 'https://www.fnscore.com/';
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
                ob_flush();
                flush();
                try {
                    dd($response->getBody()->getContents());
//                    $http = $response->getBody()->getContents();
//                    $http = iconv('gbk', 'UTF-8', $response->getBody()->getContents());
                } catch (\Exception $e) {
                    echo '没有找到数据';
                }
                if (!empty($http)) {
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($http);
                    $arr = $crawler->filter('#index_living > div > div')->each(function ($node, $i) use ($http) {

//                        dd($data);
                    });
                    dd($arr);
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



    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount) {
            return;
        }
    }
}


