<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    // 比分页




    // 全部游戏未开始
    function ScoreNotStarted(){
        return DB::table('scorenot')->get()->toArray();
    }

    // 指定获取游戏未开始
    function ScoreAppointNotStarted($id){
        $game = DB::table('games')->select('game')
            ->where('id',$id)
            ->get()
            ->toArray();
//        dd($game[0]);
        return DB::table('scorenot')->where('game',$game[0]->game)
            ->get()
            ->toArray();
    }

    // 全部游戏完场
    function ScoreOver(){
        return DB::table('scoreover')->get()->toArray();
    }

    // 指定获取游戏完场
    function ScoreAppointOver($id){
        $game = DB::table('games')->select('game')
            ->where('id',$id)
            ->get()
            ->toArray();
//        dd($game[0]);
        return DB::table('scoreover')->where('game',$game[0]->game)
            ->get()
            ->toArray();
    }














}
