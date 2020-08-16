<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LiveController extends Controller
{
    // 直播页


    function Video($id){
        $matching = DB::table('allmatching')->select('eventsimg','events','BO','tv','team1','team1img',
            'team1winnum','team2winnum','team2img','team2')
            ->where('id',$id)
            ->get()
            ->toArray();


        $matchtime = DB::table('allschedule')->select('matchtime')
            ->where('team1',$matching[0]->team1)
            ->where('team2',$matching[0]->team2)
            ->where('events',$matching[0]->events)
            ->get()
            ->toArray();
        try {
            $strtime = strtotime($matchtime[0]->matchtime);
            $date  = date('m月d日 H:i',$strtime);
        }catch (\Exception $exception){
            $date = date('m月d日');
        }

        $match = (array)$matching[0];
        $tv = array_filter(explode('|',$match['tv']));
        $tv_array = array();
        foreach ($tv as $value){
            $tv_array = array_add($tv_array,substr($value,0,strpos($value,'=>')),
                substr($value,strpos($value,'=>')+2));
        }
        $match['tv'] = $tv_array;
        return array_add($match,'time',$date);
//        dd(array_add($match,'time',date('m月d日 H:i',$strtime)));

    }





}
