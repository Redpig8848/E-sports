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
        return array(date('Y年m月d日'),date('Y-m-d'));
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
                ->orderBy('matchtime', 'desc')
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
                $con = 0;
                foreach ($tv as $key_2 => $item) {
                    $k = substr($item, 0, strpos($item, '=>'));
                    $tv_link = substr($item, strpos($item, '=>') + 2);
                    $match[$key]->tv = array_add($match[$key]->tv, $key_2,array('name'=>$k,'link'=>$tv_link));
                }
                foreach ($match[$key]->tv as $tv_value){
//                    dd(is_int(strpos($tv_value['name'],'斗2鱼')));
                    if ($con == 0 && !is_int(strpos($tv_value['name'],'斗鱼'))){
                        $match[$key]->tv[0] = array('name' => $tv_value['name'],'link'=>$tv_value['link']);
                    }
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
            if ($value->pooreconomy != "" && $value->game != "CS:GO"){
                $match[$key] = strpos($value->pooreconomy,'-') !== false
                    ? array_add((array)$match[$key],'pooimg','http://45.157.91.154/static/drop_icon.png')
                    : array_add((array)$match[$key],'pooimg','http://45.157.91.154/static/up_icon.png');
            } else {
                $match[$key]->pooreconomy = '';
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
                $con = 0;
                foreach ($tv as $key_2 => $item) {
                    $k = substr($item, 0, strpos($item, '=>'));
                    $tv_link = substr($item, strpos($item, '=>') + 2);
                    $match[$key]->tv = array_add($match[$key]->tv, $key_2,array('name'=>$k,'link'=>$tv_link));
                }
                foreach ($match[$key]->tv as $tv_value){
//                    dd(is_int(strpos($tv_value['name'],'斗2鱼')));
                    if ($con == 0 && !is_int(strpos($tv_value['name'],'斗鱼'))){
                        $match[$key]->tv[0] = array('name' => $tv_value['name'],'link'=>$tv_value['link']);
                    }
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
            if ($value->pooreconomy != "" && $value->game != "CS:GO"){
                $match[$key] = strpos($value->pooreconomy,'-') !== false
                    ? array_add((array)$match[$key],'pooimg','http://45.157.91.154/static/drop_icon.png')
                    : array_add((array)$match[$key],'pooimg','http://45.157.91.154/static/up_icon.png');
            } else {
                $match[$key]->pooreconomy = '';
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
