<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class TVSpiderController extends Controller
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



    function tv(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
//        for ($i = 10; $i >= 1; $i--) {
        $this->url = ['https://www.fnscore.com/detail/match/dota-4/match-lgwiX00003368.html?liveIndex=0&leagueId=L006573'];
//            $this->url[] = 'https://lol.dianjinghu.com/news/p/all/'.$i.'.html';
//        }
        $this->totalPageCount = 1500;
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function () use ($client, $uri) {
                    return $client->get($uri, ['verify' => false,
                        'headers' => [
                            'cookie' => 'Hm_lvt_f9784b3edd94d69659d8e4abfed9b281=1598236985,1598499176; Hm_lpvt_f9784b3edd94d69659d8e4abfed9b281=1598513879',
                            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.100 Safari/537.36',

                        ]
                    ]);
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
                    dd($http);
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





}
