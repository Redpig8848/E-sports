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

Route::get('/', function () {
    return view('welcome');
});


//-----------获取-------------------//

Route::get('FastNavigation','IndexController@FastNavigation');
Route::get('GameNavigation','IndexController@GameNavigation');
Route::get('GetAllMatch','IndexController@AllMatch');
Route::get('JustOver','IndexController@JustOver');
Route::get('NowDate','IndexController@NowDate');
Route::get('AppointMatch/{id}','IndexController@AppointMatch');



Route::get('ScoreNotStarted','ScoreController@ScoreNotStarted');
Route::get('ScoreAppointNotStarted/{id}','ScoreController@ScoreAppointNotStarted');
Route::get('GetScoreOver','ScoreController@ScoreOver');
Route::get('ScoreAppointOver/{id}','ScoreController@ScoreAppointOver');



Route::get('GetWeek','CourseController@GetWeek');
Route::get('CourseAll/{date}','CourseController@CourseAll');
Route::get('CourseAppoint/{date}/{id}','CourseController@CourseAppoint');











//--------------爬虫-----------------//
Route::get('allmatching','HomeController@index');

Route::get('allmatch','HomeController@allmatch');

Route::get('scorenot','HomeController@scorenot');
Route::get('scoreover','HomeController@scoreover');
Route::get('scoreing','HomeController@scoreing');


Route::get('Schedule','ScheduleController@index');
Route::get('today','ScheduleController@today');







Route::get('fns','DemoController@index');



