<?php

$timestamp = mktime(0,0,0,1,1,date('Y'));

$stime =  strtotime(date('Y-m-d',$timestamp));

$timestamp = mktime(0,0,0,12,31,date('Y'));

$etime = strtotime(date('Y-m-d',$timestamp));

while($stime <= $etime){
    echo date('Y-m-d',$stime).chr(10);
    $stime = $stime + 86400;
}


































