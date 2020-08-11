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






}
