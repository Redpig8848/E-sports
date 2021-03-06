<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    // 赛程页面
    function compareByTimeStamp($time1, $time2)

    {

        if (strtotime($time1) < strtotime($time2))

            return 1;

        else if (strtotime($time1) > strtotime($time2))

            return -1;

        else

            return 0;

    }
    // 获取当前星期的日期
    function GetWeek($format='m月d日'){
        date_default_timezone_set('Asia/Shanghai');
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
            $date_time3 = date('Y年m月d日' ,strtotime( '+' . $i+1-$week .' days', $time));
            $date[$i]['date'] = $date_time;
            $date[$i]['date2'] = $date_time2;
            $date[$i]['date3'] = $date_time3;
            $date[$i]['week'] = $weekname[$i];
        }
        return $date;
    }

    // 全部游戏
    function CourseAll($date){
        return DB::table('allschedule')->where('matchtime','like',$date.'%')
            ->orderBy('matchtime','asc')
            ->get()
            ->toArray();
    }

    // 指定游戏
    function CourseAppoint($date,$id){
        if ($id == 0){
            return $this->CourseAll($date);
        }
        $game = DB::table('games')->select('game')
            ->where('id',$id)
            ->get()
            ->toArray();

        return DB::table('allschedule')->where('matchtime','like',$date.'%')
            ->where('gametype',$game[0]->game)
            ->orderBy('matchtime','asc')
            ->get()
            ->toArray();
    }












}
