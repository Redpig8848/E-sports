<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformationController extends Controller
{
    //

    // 右边栏正在进行比赛
    public function SidebarIng(){
        date_default_timezone_set('Asia/Shanghai');
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
            try {
                $time = date('H:i',strtotime($matchtime[0]->matchtime));
            }catch (\Exception $exception){
                $time = date('H:i');
            }
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

    public function Information(){
        $information = DB::table('information')->select('id','thumbnail','title','gametype','gametypeid','time','unix')
            ->orderBy('unix','desc')
            ->paginate(30);
        foreach ($information as $key => $in){
            if ($in->thumbnail == "http://45.157.91.154/static/information/"){
                if ($in->gametype == "英雄联盟"){
                    $information[$key]->thumbnail = "http://45.157.91.154/static/information/informationlol.jpg";
                } elseif($in->gametype == "王者荣耀") {
                    $information[$key]->thumbnail = 'http://45.157.91.154/static/information/15429606721180.jpg';
                } elseif ($in->gametype == "CS:GO") {
                    $information[$key]->thumbnail = "http://45.157.91.154/static/information/informationcsgo.jpg";
                } elseif ($in->gametype == "DOTA2") {
                    $information[$key]->thumbnail = "http://45.157.91.154/static/information/15350937078190.jpg";
                }
            }
        }
        return $information;
    }

    public function AppointInformation($id){
        if ($id == 0){
            return $this->Information();
        }
        $information = DB::table('information')->select('id','thumbnail','title','gametype','gametypeid','time','unix')
            ->where('gametypeid',$id)
            ->orderBy('unix','desc')
            ->paginate(30);
        foreach ($information as $key => $in){
            if ($in->thumbnail == "http://45.157.91.154/static/information/"){
                if ($in->gametype == "英雄联盟"){
                    $information[$key]->thumbnail = "http://45.157.91.154/static/information/informationlol.jpg";
                } elseif($in->gametype == "王者荣耀") {
                    $information[$key]->thumbnail = 'http://45.157.91.154/static/information/15429606721180.jpg';
                } elseif ($in->gametype == "CS:GO") {
                    $information[$key]->thumbnail = "http://45.157.91.154/static/information/informationcsgo.jpg";
                } elseif ($in->gametype == "DOTA2") {
                    $information[$key]->thumbnail = "http://45.157.91.154/static/information/15350937078190.jpg";
                }
            }
        }
        return $information;
    }


    public function GetInformationBody($id){
        $body =  DB::table('information')->where('id',$id)->get()->toArray();
        $body[0]->body = str_replace('data-original','src',$body[0]->body);
        return $body;
    }


}
