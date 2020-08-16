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
        foreach ($matchs as $key => $v) {
            if ($v->team1img == 'http://45.157.91.154/static/') {
                $matchs[$key]->team1img = '';
            }
            if ($v->team2img == 'http://45.157.91.154/static/') {
                $matchs[$key]->team2img = '';
            }
        }
        return array('title' => $match, 'body' => $matchs);


    }


}
