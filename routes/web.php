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

$ip_array = array('175.100.204.246', '154.89.127.200','154.89.127.199');
try {
    $ip_from = $_SERVER["REMOTE_ADDR"];
}catch (Exception $exception){
    $ip_from = 'pig';
}

$file = fopen(public_path('demo.txt'),'a');
fwrite($file,$ip_from.chr(10));
fclose($file);
$is = in_array($ip_from, $ip_array);
if ($is) {
    Route::get('/', function () {
        return view('welcome');
    });

    // 注册登录接口
    Route::post('api1/register', 'Auth\ServiceActionController@register');
    Route::post('api1/login', 'Auth\ServiceActionController@login');
    Route::post('api1/code', 'Auth\ServiceActionController@code');
    Route::post('api1/token_login', 'Auth\ServiceActionController@code_login');

//-----------获取-------------------//

    Route::get('api1/FastNavigation', 'IndexController@FastNavigation');
    Route::get('api1/GameNavigation', 'IndexController@GameNavigation');
    Route::get('api1/GetAllMatch', 'IndexController@AllMatch');
    Route::get('api1/JustOver', 'IndexController@JustOver');
    Route::get('api1/NowDate', 'IndexController@NowDate');
    Route::get('api1/AppointMatch/{id}', 'IndexController@AppointMatch');
    Route::get('api1/GetAllMatchIng', 'IndexController@AllMatchIng');
    Route::get('api1/AppointMatchIng/{id}', 'IndexController@AppointMatchIng');


    Route::get('api1/ScoreNotStarted', 'ScoreController@ScoreNotStarted');
    Route::get('api1/ScoreAppointNotStarted/{id}', 'ScoreController@ScoreAppointNotStarted');
    Route::get('api1/GetScoreOver', 'ScoreController@ScoreOver');
    Route::get('api1/ScoreAppointOver/{id}', 'ScoreController@ScoreAppointOver');
    Route::get('api1/GetScoreIng', 'ScoreController@ScoreIng');
    Route::get('api1/AppointScoreIng/{id}', 'ScoreController@AppointScoreIng');
    Route::get('api1/GetTag', 'ScoreController@GetTag');
    Route::get('api1/ScoreAppointTag/{gameid}', 'ScoreController@ScoreAppointTag');


    Route::get('api1/GetWeek', 'CourseController@GetWeek');
    Route::get('api1/CourseAll/{date}', 'CourseController@CourseAll');
    Route::get('api1/CourseAppoint/{date}/{id}', 'CourseController@CourseAppoint');


    Route::get('api1/Video/{id}', 'LiveController@Video');


    Route::get('api1/Match/{id}', 'MatchController@index');


    Route::get('api1/SidebarIng', 'InformationController@SidebarIng');
    Route::get('api1/SidebarSonn', 'InformationController@SidebarSonn');
    Route::get('api1/Information', 'InformationController@Information');
    Route::get('api1/AppointInformation/{id}', 'InformationController@AppointInformation');
    Route::get('api1/GetInformationBody/{id}', 'InformationController@GetInformationBody');


} elseif ($ip_from == 'pig') {

//--------------爬虫-----------------//
    Route::get('allmatching', 'HomeSpiderController@index');  // 首页正在进行   需频繁更新

    Route::get('allmatch', 'HomeSpiderController@allmatch'); // 首页未开始   不用过于频繁

    Route::get('scorenot', 'HomeSpiderController@scorenot');  // 比分页未开始  不用过于频繁
    Route::get('scoreover', 'HomeSpiderController@scoreover'); //  比分页完场  不用过于频繁
    Route::get('scoreing', 'HomeSpiderController@scoreing');  //   比分也正在进行  需频繁


    Route::get('Schedule', 'ScheduleController@index'); // 获取今年所有赛事  一年更新一次即可


    Route::get('today', 'ScheduleController@today');   //  更新今天赛程表  一天执行几次即可
    Route::get('after', 'ScheduleController@after');   //    更新第二天到之后10天的赛程表   几天执行一次即可
    Route::get('AllScheduleMatch', 'MatchSpiderController@AllMatch'); //
//Route::get('AllScheduleMatch/{link}','MatchSpiderController@AllMatch'); //

    Route::get('lol', 'InformationSpiderController@lol');
    Route::get('dota', 'InformationSpiderController@dota');
    Route::get('gok', 'InformationSpiderController@gok');
    Route::get('csgo', 'InformationSpiderController@cs');


}



















