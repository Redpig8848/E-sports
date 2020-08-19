<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$ip_array = array('175.100.204.246','127.0.0.1','154.89.127.200');
$ip_from = $_SERVER["REMOTE_ADDR"];
$is = in_array($ip_from, $ip_array);
if ($is){
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/api/', function () {
        // 注册登录接口
        Route::post('register','Auth\ServiceActionController@register');
        Route::post('login','Auth\ServiceActionController@login');
        Route::post('code','Auth\ServiceActionController@code');
        Route::post('token_login','Auth\ServiceActionController@code_login');

//-----------获取-------------------//

        Route::get('FastNavigation','IndexController@FastNavigation');
        Route::get('GameNavigation','IndexController@GameNavigation');
        Route::get('GetAllMatch','IndexController@AllMatch');
        Route::get('JustOver','IndexController@JustOver');
        Route::get('NowDate','IndexController@NowDate');
        Route::get('AppointMatch/{id}','IndexController@AppointMatch');
        Route::get('GetAllMatchIng','IndexController@AllMatchIng');
        Route::get('AppointMatchIng/{id}','IndexController@AppointMatchIng');



        Route::get('ScoreNotStarted','ScoreController@ScoreNotStarted');
        Route::get('ScoreAppointNotStarted/{id}','ScoreController@ScoreAppointNotStarted');
        Route::get('GetScoreOver','ScoreController@ScoreOver');
        Route::get('ScoreAppointOver/{id}','ScoreController@ScoreAppointOver');
        Route::get('GetScoreIng','ScoreController@ScoreIng');
        Route::get('AppointScoreIng/{id}','ScoreController@AppointScoreIng');
        Route::get('GetTag','ScoreController@GetTag');
        Route::get('ScoreAppointTag/{gameid}','ScoreController@ScoreAppointTag');



        Route::get('GetWeek','CourseController@GetWeek');
        Route::get('CourseAll/{date}','CourseController@CourseAll');
        Route::get('CourseAppoint/{date}/{id}','CourseController@CourseAppoint');




        Route::get('Video/{id}','LiveController@Video');


        Route::get('Match/{id}','MatchController@index');



        Route::get('SidebarIng','InformationController@SidebarIng');
        Route::get('SidebarSonn','InformationController@SidebarSonn');
        Route::get('Information','InformationController@Information');
        Route::get('AppointInformation/{id}','InformationController@AppointInformation');
        Route::get('GetInformationBody/{id}','InformationController@GetInformationBody');

    });



} elseif($ip_from == '127.0.0.1' || $ip_from == 'localhost'){

//--------------爬虫-----------------//
    Route::get('allmatching','HomeSpiderController@index');  // 首页正在进行   需频繁更新

    Route::get('allmatch','HomeSpiderController@allmatch'); // 首页未开始   不用过于频繁

    Route::get('scorenot','HomeSpiderController@scorenot');  // 比分页未开始  不用过于频繁
    Route::get('scoreover','HomeSpiderController@scoreover'); //  比分页完场  不用过于频繁
    Route::get('scoreing','HomeSpiderController@scoreing');  //   比分也正在进行  需频繁


    Route::get('Schedule','ScheduleController@index'); // 获取今年所有赛事  一年更新一次即可



    Route::get('today','ScheduleController@today');   //  更新今天赛程表  一天执行几次即可
    Route::get('after','ScheduleController@after');   //    更新第二天到之后10天的赛程表   几天执行一次即可
    Route::get('AllScheduleMatch','MatchSpiderController@AllMatch'); //
//Route::get('AllScheduleMatch/{link}','MatchSpiderController@AllMatch'); //

    Route::get('lol','InformationSpiderController@lol');
    Route::get('dota','InformationSpiderController@dota');
    Route::get('gok','InformationSpiderController@gok');
    Route::get('csgo','InformationSpiderController@cs');


}



















