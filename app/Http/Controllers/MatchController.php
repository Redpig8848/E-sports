<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    //
    // 根据ID获取赛事所有比赛
    public function index($id){
        $match = DB::table('match')->where('id',$id)
            ->get()
            ->toArray();
        $matchs =  DB::table('schedulematch')->where('eventid',$id)
            ->get()
            ->toArray();

        return array('title'=>$match,'body'=>$matchs);





    }






}
