<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ServiceActionController extends Controller
{
    //

    public function login(Request $request){

    }



    public function register(Request $request){
//        $ver_exists = DB::table('user')->where('verification_code',$request['code'])->exists();
        $ver_exists = 1;
        $phone_exists = DB::table('user')->where('phone',$request['phone'])->exists();
        if ($phone_exists){
            return '该手机号已被注册';
        }
        if ($ver_exists){
            $token = str_random(64);
            $id = DB::table()->insertGetId(array(
                'name'=>str_random(rand(4,10)),
                'phone'=>$request['phone'],
                'password'=>$request['password'],
                'remember_tokem'=>'',
                'api_token'=>$token,
                'verification_code'=>''
            ));
            if ($id){
                return $token;
            } else {
                return '注册错误，请重试';
            }
        } else {
            return '验证码错误';
        }
    }








}
