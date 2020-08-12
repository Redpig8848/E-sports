<?php

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

function get_week($format='m月d日'){
    $time = time();
    //获取当前周几
    $week = date('w', $time);
    $weekname = array('星期一','星期二','星期三','星期四','星期五','星期六','星期日');
    //星期日排到末位
    if(empty($week)){
        $week=7;
    }
    $date = [];
    for ($i=0; $i<7; $i++){
        $date_time = date($format ,strtotime( '+' . $i+1-$week .' days', $time));
        $date_time2 = date('Y-m-d' ,strtotime( '+' . $i+1-$week .' days', $time));
        $date[$i]['date'] = $date_time;
        $date[$i]['date2'] = $date_time2;
        $date[$i]['week'] = $weekname[$i];
    }
    return $date;
}

$array=  'https://www.500bf.com/static/index/img/cs_16kill.png';
print_r(explode('|',$array));




























