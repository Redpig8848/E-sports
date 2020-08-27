<?php
use GuzzleHttp\Client;




//$timestamp = mktime(0,0,0,1,1,date('Y'));
//
//$stime =  strtotime(date('Y-m-d',$timestamp));
//
//$timestamp = mktime(0,0,0,12,31,date('Y'));
//
//$etime = strtotime(date('Y-m-d',$timestamp));
//
//while($stime <= $etime){
//    echo date('Y-m-d',$stime).chr(10);
//    $stime = $stime + 86400;
//}
//
//function get_week($format='m月d日'){
//    $time = time();
//    //获取当前周几
//    $week = date('w', $time);
//    $weekname = array('星期一','星期二','星期三','星期四','星期五','星期六','星期日');
//    //星期日排到末位
//    if(empty($week)){
//        $week=7;
//    }
//    $date = [];
//    for ($i=0; $i<7; $i++){
//        $date_time = date($format ,strtotime( '+' . $i+1-$week .' days', $time));
//        $date_time2 = date('Y-m-d' ,strtotime( '+' . $i+1-$week .' days', $time));
//        $date[$i]['date'] = $date_time;
//        $date[$i]['date2'] = $date_time2;
//        $date[$i]['week'] = $weekname[$i];
//    }
//    return $date;
//}
//
//$array=  'https://www.500bf.com/static/index/img/cs_16kill.png';
//print_r(explode('|',$array));
//$time = '2019-05-18 18:17          ';
//
//print strtotime($time);
//
//$rand_code = '';
//for($i = 0;$i < 6;$i++) {
//    $rand_code = $rand_code.rand(0,9);
//}
//
//$str = iconv('utf-8','gbk','您好,您的验证码为'.$rand_code.',请保存好不要随意给其他人,YBE-Game在此欢迎您的加入！');
//
//$url='http://sms.webchinese.cn/web_api/?Uid=dJHYzCbq98pjT&Key=d41d8cd98f00b204e980&smsMob=18683346545&smsText='.$str;
//echo Get($url);
//function Get($url)
//{
//    $ch = curl_init();
//// curl_init()需要php_curl.dll扩展
//    $timeout = 5;
//    curl_setopt ($ch, CURLOPT_URL, $url);
//    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//    $file_contents = curl_exec($ch);
//    curl_close($ch);
//    return $file_contents;
//}
//
//
//


//print(file_get_contents('https://www.fnscore.com/detail/match/dota-4/match-lgwiX00003368.html?liveIndex=0&leagueId=L006573'));


//print strpos(array(4,5,6),"1111232323")

$client = new Client();
$client->get('https://www.fnscore.com/detail/match/dota-4/match-lgwiX00003368.html?liveIndex=0&leagueId=L006573',['verify' => false]);










