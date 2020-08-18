<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //

    function NowDate()
    {
        date_default_timezone_set('Asia/Shanghai');
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
        foreach ($games as $key=>$game) {
            $Navigation[$key] = (array)['type' => $game->game];
            $Navigation[$key]['item'] = (array)DB::table('match')->select('id', 'match', 'matchimg')
                ->where('game', $game->game)
                ->orderBy('id', 'desc')
                ->limit(4)
                ->get()
                ->toArray();
//            array_unshift($Navigation[$game->game],['game'=>$game->game,'gameid'=>$game->id]);
        }
        return (array)$Navigation;
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

            } else {
                $match[$key]->tv = array();
            }
            if ($value->team1special !== ""){
                $match[$key]->team1special = explode('|',$value->team1special);
            } else {
                $match[$key]->team1special = array();
            }
            if ($value->team2special !== ""){
                $match[$key]->team2special = explode('|',$value->team2special);
            }else {
                $match[$key]->team2special = array();
            }
            if ($value->pooreconomy != ""){
                $match[$key] = strpos($value->pooreconomy,'-') !== false
                    ? array_add((array)$match[$key],'pooimg','http://qn.gunqiu.com/pcweb/drop_icon.png')
                    : array_add((array)$match[$key],'pooimg','http://qn.gunqiu.com/pcweb/up_icon.png');
            } else {
                $match[$key] = array_add((array)$match[$key],'pooimg','');
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

            } else {
                $match[$key]->tv = array();
            }
            if ($value->team1special !== ""){
                $match[$key]->team1special = explode('|',$value->team1special);
            } else {
                $match[$key]->team1special = array();
            }
            if ($value->team2special !== ""){
                $match[$key]->team2special = explode('|',$value->team2special);
            } else {
                $match[$key]->team2special = array();
            }
            if ($value->pooreconomy != ""){
                $match[$key] = strpos($value->pooreconomy,'-') !== false
                    ? array_add((array)$match[$key],'pooimg','http://45.157.91.154/static/up_icon.png')
                    : array_add((array)$match[$key],'pooimg','http://45.157.91.154/static/drop_icon.png');
            } else {
                $match[$key] = array_add((array)$match[$key],'pooimg','');
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
