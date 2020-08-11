<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //

    function NowDate(){
        return date('Y年m月d日');
    }


    // 快速导航
    function FastNavigation()
    {
        $games = DB::table('games')->get()->toArray();
        return $games;
    }


    // 游戏赛事导航
    function GameNavigation()
    {
        $games = $this->FastNavigation();
        $Navigation = array();
        foreach ($games as $game) {
            $Navigation[$game->game] = DB::table('match')->select('id', 'match', 'matchimg')
                ->where('game', $game->game)
                ->orderBy('id', 'desc')
                ->limit(4)
                ->get()
                ->toArray();
        }
        return $Navigation;
    }

    // 首页全部游戏正在进行
    function AllMatchIng()
    {

    }

    // 首页全部游戏未开始
    function AllMatch()
    {
        return DB::table('allmatch')->get()->toArray();
    }

    // 首页指定游戏未开始
    function AppointMatch($id){
        $game = DB::table('games')->select('game')
            ->where('id',$id)
            ->get()
            ->toArray();
//        dd($game[0]);
        return DB::table('allmatch')->where('game',$game[0]->game)
            ->get()
            ->toArray();
    }




    // 首页右侧刚刚结束
    function JustOver()
    {
        return DB::table('scoreover')->select('gameimg', 'team1', 'score', 'team2', 'time')
            ->limit(10)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }


}
