<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    //
    // 根据ID获取赛事所有比赛
    public function index($id)
    {
        $match = DB::table('match')->where('id', $id)
            ->get()
            ->toArray();
        $matchs = DB::table('schedulematch')->where('eventid', $id)
            ->get()
            ->toArray();
//        dd($matchs);
        foreach ($matchs as $key => $v) {
            if ($v->team1img == 'http://45.157.91.154/static/') {
                $matchs[$key]->team1img = '';
            }
            if ($v->team2img == 'http://45.157.91.154/static/') {
                $matchs[$key]->team2img = '';
            }

            $time1 = substr($v->time,0,5);
            $time2 =  substr($v->time,7);
            $matchs[$key]->time = array($time1,$time2);
        }
        return array('title' => $match, 'body' => $matchs);


    }


}
