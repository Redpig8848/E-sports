<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    // 比分页

    public function GetTag(){
        return DB::table('scoretag')->get()->toArray();
    }



    // 全部游戏正在进行
    public function ScoreIng()
    {
        $scoreing = DB::table('scoreing')->get()->toArray();
        foreach ($scoreing as $key => $value) {
//            dd($value->tv);
            if ($value->tv !== "") {
                $tv = explode('|', $value->tv);
                $tv = array_filter($tv);
                $scoreing[$key]->tv = array();
                foreach ($tv as $item) {
                    $k = substr($item, 0, strpos($item, '=>'));
                    array_push($scoreing[$key]->tv, $k);
                }

            } else {
                $scoreing[$key]->tv = array();
            }

            if ($value->team1killspecial !== "") {
                $scoreing[$key]->team1killspecial = explode('|', $value->team1killspecial);
            } else {
                $scoreing[$key]->team1killspecial = array();
            }

            if ($value->team1tag3special !== "") {
                $scoreing[$key]->team1tag3special = explode('|', $value->team1tag3special);
            } else {
                $scoreing[$key]->team1tag3special = array();
            }

            if ($value->team1tag4special !== "") {
                $scoreing[$key]->team1tag4special = explode('|', $value->team1tag4special);
            } else {
                $scoreing[$key]->team1tag4special = array();
            }

            if ($value->team1tag5special !== "") {
                $scoreing[$key]->team1tag5special = explode('|', $value->team1tag5special);
            } else {
                $scoreing[$key]->team1tag5special = array();
            }

            if ($value->team2killspecial !== "") {
                $scoreing[$key]->team2killspecial = explode('|', $value->team2killspecial);
            } else {
                $scoreing[$key]->team2killspecial = array();
            }

            if ($value->team2tag3special !== "") {
                $scoreing[$key]->team2tag3special = explode('|', $value->team2tag3special);
            } else {
                $scoreing[$key]->team2tag3special = array();
            }

            if ($value->team2tag4special !== "") {
                $scoreing[$key]->team2tag4special = explode('|', $value->team2tag4special);
            } else {
                $scoreing[$key]->team2tag4special = array();
            }

            if ($value->team2tag5special !== "") {
                $scoreing[$key]->team2tag5special = explode('|', $value->team2tag5special);
            } else {
                $scoreing[$key]->team2tag5special = array();
            }

            if ($value->team1tag6num != "") {
                $scoreing[$key] = strpos($value->team1tag6num, '-') !== false
                    ? array_add((array)$scoreing[$key], 'pooimg', 'http://qn.gunqiu.com/pcweb/up_icon.png')
                    : array_add((array)$scoreing[$key], 'pooimg', 'http://qn.gunqiu.com/pcweb/drop_icon.png');
            } else {
                $scoreing[$key] = array_add((array)$scoreing[$key], 'pooimg', '');
            }
        }
        return $scoreing;

    }

// 指定游戏正在进行
    public function AppointScoreIng($id)
    {
        if ($id == 0){
            return $this->ScoreIng();
        }
        $game = DB::table('games')->select('game')
            ->where('id', $id)
            ->get()
            ->toArray();
        $scoreing = DB::table('scoreing')->where('game', $game[0]->game)->get()->toArray();
        foreach ($scoreing as $key => $value) {
//            dd($value->tv);
            if ($value->tv !== "") {
                $tv = explode('|', $value->tv);
                $tv = array_filter($tv);
                $scoreing[$key]->tv = array();
                foreach ($tv as $item) {
                    $k = substr($item, 0, strpos($item, '=>'));
                    array_push($scoreing[$key]->tv, $k);
                }

            } else {
                $scoreing[$key]->tv = array();
            }

            if ($value->team1killspecial !== "") {
                $scoreing[$key]->team1killspecial = explode('|', $value->team1killspecial);
            } else {
                $scoreing[$key]->team1killspecial = array();
            }

            if ($value->team1tag3special !== "") {
                $scoreing[$key]->team1tag3special = explode('|', $value->team1tag3special);
            } else {
                $scoreing[$key]->team1tag3special = array();
            }

            if ($value->team1tag4special !== "") {
                $scoreing[$key]->team1tag4special = explode('|', $value->team1tag4special);
            } else {
                $scoreing[$key]->team1tag4special = array();
            }

            if ($value->team1tag5special !== "") {
                $scoreing[$key]->team1tag5special = explode('|', $value->team1tag5special);
            } else {
                $scoreing[$key]->team1tag5special = array();
            }

            if ($value->team2killspecial !== "") {
                $scoreing[$key]->team2killspecial = explode('|', $value->team2killspecial);
            } else {
                $scoreing[$key]->team2killspecial = array();
            }

            if ($value->team2tag3special !== "") {
                $scoreing[$key]->team2tag3special = explode('|', $value->team2tag3special);
            } else {
                $scoreing[$key]->team2tag3special = array();
            }

            if ($value->team2tag4special !== "") {
                $scoreing[$key]->team2tag4special = explode('|', $value->team2tag4special);
            } else {
                $scoreing[$key]->team2tag4special = array();
            }

            if ($value->team2tag5special !== "") {
                $scoreing[$key]->team2tag5special = explode('|', $value->team2tag5special);
            } else {
                $scoreing[$key]->team2tag5special = array();
            }


            if ($value->team1tag6num != "") {
                $scoreing[$key] = strpos($value->team1tag6num, '-') !== false
                    ? array_add((array)$scoreing[$key], 'pooimg', 'http://qn.gunqiu.com/pcweb/up_icon.png')
                    : array_add((array)$scoreing[$key], 'pooimg', 'http://qn.gunqiu.com/pcweb/drop_icon.png');
            } else {
                $scoreing[$key] = array_add((array)$scoreing[$key], 'pooimg', '');
            }
        }
        return $scoreing;

    }


    // 全部游戏未开始
    function ScoreNotStarted()
    {
        return DB::table('scorenot')->get()->toArray();
    }

    // 指定获取游戏未开始
    function ScoreAppointNotStarted($id)
    {
        if ($id == 0){
            return DB::table('scorenot')
                ->get()
                ->toArray();;
        }
        $game = DB::table('games')->select('game')
            ->where('id', $id)
            ->get()
            ->toArray();
//        dd($game[0]);
        return DB::table('scorenot')->where('game', $game[0]->game)
            ->get()
            ->toArray();
    }

    // 全部游戏完场
    function ScoreOver()
    {
        return DB::table('scoreover')->get()->toArray();
    }

    // 指定获取游戏完场
    function ScoreAppointOver($id)
    {
        if ($id == 0){
            return DB::table('scoreover')
                ->get()
                ->toArray();
        }
        $game = DB::table('games')->select('game')
            ->where('id', $id)
            ->get()
            ->toArray();
//        dd($game[0]);
        return DB::table('scoreover')->where('game', $game[0]->game)
            ->get()
            ->toArray();
    }


    function ScoreAppointTag($gameid,$tagid){
        // 0 = 即时
        if($tagid == 0){
            return $this->AppointScoreIng($gameid);
        }elseif ($tagid == 1) { // 1 = 完场
            return $this->ScoreAppointOver($gameid);
        }
    }


}
