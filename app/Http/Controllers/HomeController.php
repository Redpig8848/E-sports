<?php

namespace App\Http\Controllers;

use App\Content;
use App\Title;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;
use Symfony\Component\DomCrawler\Crawler;

class HomeController extends Controller
{
    private $totalPageCount;
    private $counter        = 1;
    private $concurrency    = 300;  // 同时并发抓取

    protected $startUrl = 'https://www.autotimes.com.cn/news/1.html';

    public function index()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        for ($i=1;$i<2;$i++){
            $this->url[] = 'https://www.500bf.com/';
        }
        $this->totalPageCount = 1500;
        $client = new Client();
//        $client->setDefaultOption('verify',false);
//        dd($this->url);
        $requests = function ($total) use ($client) {
            foreach ($this->url as $uri) {
                yield function() use ($client, $uri) {
                    return $client->get($uri,['verify' => false]);
                };
            }
        };
//        dd(1);
//        dd($requests($this->totalPageCount));

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled'   => function ($response, $index){
                echo '爬取'.$this->url[$index];
                echo '<br>';
                ob_flush();
                flush();
                try{
//                    dd($response->getBody()->getContents());
                    $http = $response->getBody()->getContents();
//                    $http = iconv('gbk', 'UTF-8', $response->getBody()->getContents());
                }catch (\Exception $e){
                    echo '没有找到数据';
                }
                if(!empty($http)){
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($http);
                    $arr = $crawler->filter('#index_living > div > div')->each(function ($node,$i) use ($http) {
                        $src = $node->filter('div > div.header > div.item-league-panel > img')->attr('src');
                        dd($src);
                        //                        $data['href'] = $node->filter('a')->attr('href');
//                        $data['title'] = $node->filter('a > h3')->text();
//                        dd($data['title']);

//                            $data['author'] = $node->filter('li > div.r_info > div.furt > span.zuozhe')->text();
//                            $data['created_at'] = date('Y-m-d H:i:s');
//                            $data['updated_at'] = date('Y-m-d H:i:s');
//                            $data['webid'] = 4;
//                        dd($data);
                        return $data;
                    });
                    $bool = DB::table('title')->insert($arr);
                    echo $bool;
                    echo '<br>';
                    $this->countedAndCheckEnded();
                }
            },
            'rejected' => function ($reason, $index){
            dd('rejected');
//                    log('test',"rejected" );
//                    log('test',"rejected reason: " . $reason );
                $this->countedAndCheckEnded();
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();

    }

    public function content()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
//        $this->title = Title::select('href')->get();
        $this->title = Title::select('href')->get();
//        dd($this->title[1]);
        $this->totalPageCount = count($this->title);
        $headers = ['user-agent' => 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)',];
        $client = new Client(['timeout' => 20, 'headers' => $headers]);
        $requests = function ($total) use ($client) {
            foreach ($this->title as $uri) {
                yield function() use ($client, $uri) {
                    $href = substr($uri->href,0,strpos($uri->href,"#"));
                    return $client->getAsync($href);

                };
            }
        };
        $pool = new Pool($client, $requests($this->totalPageCount), [

            'concurrency' => $this->concurrency,
            'fulfilled'   => function ($response, $index){
                $file = @fopen(public_path('body/txt.txt'),'a');
                echo '爬取'.$this->title[$index]->href;
                echo '<br>';
                ob_flush();
                flush();
                try{
                    $http = iconv('gbk', 'UTF-8', $response->getBody()->getContents());;
                } catch(\Exception $e) { // I guess its InvalidArgumentException in this case
                    $this->countedAndCheckEnded();
                }

                $crawler = new Crawler();
                $crawler->addHtmlContent($http);
                $data['content'] = $crawler->filter('#articleContent > p')->text();


                $txt = $this->chuli($data['content']).chr(10);
                $bool = fwrite($file,$txt);
                fclose($file);
                if ($bool){
                    echo 'save success';
                    echo '<br>';
                }else{
                    echo 'save fail';
                    echo '<br>';
                }
                $this->countedAndCheckEnded();
            },
            'rejected' => function ($reason, $index){
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
        if ($this->counter < $this->totalPageCount){
            return;
        }
    }

    //截取文章的标题
    function gettitle($html){

        echo '正在截取标题'.'<br>';
        $str = substr($html,strpos($html,'<h1 id="artical_topic">'));
        $h1 = substr($str,0,strpos($str,'</h1>')+5);
        $t = substr($h1,23);
        $title = substr($t,0,strpos($t,'</h1>'));
        echo '截取成功！！'.'<br>';
        return $title;
    }

    //截取文章的内容
    function getbody($ta){



        echo '正在截取文章内容'.'<br>';
        $t = substr($ta,strpos($ta,'<!--mainContent begin-->')+24);
        $t = substr($t,0,strpos($t,'<!--mainContent end-->'));
        echo '截取成功！！'.'<br>';
        return $t;
    }

    function chuli($str){
//        $str = str_replace('<a','<div',$str);
        return str_replace(array("\r\n", "\r", "\n" ,"\t"), "", $str);
    }

}
