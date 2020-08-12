<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    //
    // 根据ID获取赛事所有比赛
    public function index($id){
        return DB::table('schedulematch')->where('eventid',$id)
            ->get()
            ->toArray();

    }






}
