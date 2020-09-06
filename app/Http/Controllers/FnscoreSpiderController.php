<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

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
        for ($i = 1; $i < 2; $i++) {
            $this->url[] = 'https://www.fnscore.com/api/common/getMatchLives?timestamp=1599198082859&sign=p1E%252Bcis2nVMRXEtWz3xdL7yHMxvJUHBQmNU0g9U5PSU%253D';
        }
        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->post($uri, ['verify' => false,
                        'headers' => [
                            'Content-Type' => 'application/json; charset=utf-8',
                            'cookie' => 'Hm_lvt_f9784b3edd94d69659d8e4abfed9b281=1598236985,1598499176; Hm_lpvt_f9784b3edd94d69659d8e4abfed9b281=1598513879',
                            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.100 Safari/537.36',
                            'dataType' => 'json',
                            'X-Content-Type-Options' => 'nosniff',
                        ]]);
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
                    $http = $response->getBody()->getContents();
                    dd(json_decode($http));
                    $file = fopen(public_path('demo.json'),'w');
                    fwrite($file,$http);
                    fclose($file);
                    $http = file_get_contents(public_path('demo.json'));
                    $http = json_encode($http,256);

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
