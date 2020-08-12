<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //

    function NowDate()
    {
        return date('Y年m月d日');
    }


    // 快速导航
    function FastNavigation()
    {

        $games = DB::table('games')->orderBy('id','asc')->get()->toArray();
        return $games;
    }


    // 游戏赛事导航
    function GameNavigation()
    {
        $games = $this->FastNavigation();
        $Navigation = array();
        foreach ($games as $game) {
            $Navigation[$game->game] = ['type' => $game->game];
            $Navigation[$game->game]['item'] = DB::table('match')->select('id', 'match', 'matchimg')
                ->where('game', $game->game)
                ->orderBy('id', 'desc')
                ->limit(4)
                ->get()
                ->toArray();
//            array_unshift($Navigation[$game->game],['game'=>$game->game,'gameid'=>$game->id]);
        }
        return $Navigation;
    }

    // 首页全部游戏正在进行
    function AllMatchIng()
    {
        $match = DB::table('allmatching')->get()->toArray();
        foreach ($match as $key => $value) {
//            dd($value->tv);
            if ($value->tv !== "") {
                $tv = explode('|', $value->tv);
                $tv = array_filter($tv);
                $match[$key]->tv = array();
                foreach ($tv as $item) {
                    $k = substr($item, 0, strpos($item, '=>'));
                    array_push($match[$key]->tv, $k);
                }

            }
        }
        return $match;
    }

    // 首页指定游戏正在进行
    function AppointMatchIng($id){
        if ($id == 0){
            return $this->AllMatchIng();
        }
        $game = DB::table('games')->select('game')
            ->where('id', $id)
            ->get()
            ->toArray();
//        dd($game[0]);
        $match =  DB::table('allmatching')->where('game', $game[0]->game)
            ->get()
            ->toArray();
        foreach ($match as $key => $value) {
//            dd($value->tv);
            if ($value->tv !== "") {
                $tv = explode('|', $value->tv);
                $tv = array_filter($tv);
                $match[$key]->tv = array();
                foreach ($tv as $item) {
                    $k = substr($item, 0, strpos($item, '=>'));
                    array_push($match[$key]->tv, $k);
                }

            }
        }
        return $match;
    }


    // 首页全部游戏未开始
    function AllMatch()
    {
        return DB::table('allmatch')->get()->toArray();
    }

    // 首页指定游戏未开始
    function AppointMatch($id)
    {
        if ($id == 0){
            return $this->AllMatch();
        }
        $game = DB::table('games')->select('game')
            ->where('id', $id)
            ->get()
            ->toArray();
//        dd($game[0]);
        return DB::table('allmatch')->where('game', $game[0]->game)
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
