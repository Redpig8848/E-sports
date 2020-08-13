<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformationController extends Controller
{
    //

    // 右边栏正在进行比赛
    public function SidebarIng(){
        $match = DB::table('allmatching')->limit(4)
            ->select('game','team1','team1winnum','team2winnum','team2','events')
            ->get()
            ->toArray();
        foreach ($match as $key => $item){
            $game = DB::table('games')->where('game',$item->game)
                ->select('gameimg')
                ->get()
                ->toArray();
            $matchtime = DB::table('allschedule')->select('matchtime')
                ->where('team1',$item->team1)
                ->where('team2',$item->team2)
                ->where('events',$item->events)
                ->get()
                ->toArray();
            $time = date('H:i',strtotime($matchtime[0]->matchtime));
            $match[$key]->game = $game[0]->gameimg;
            $match[$key] = array_add((array)$match[$key],'time',$time);

        }
        return $match;

    }


    // 右边栏即将开始比赛
    public function SidebarSonn(){
        $match = DB::table('allmatch')->limit(10)
            ->select('gameimg','team1','team2','time')
            ->get()
            ->toArray();

        return $match;
    }





}