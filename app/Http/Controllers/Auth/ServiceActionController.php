<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ServiceActionController extends Controller
{
    //

    public function login(Request $request)
    {
        $is = DB::table('users')->where('phone', $request['phone'])
            ->where('password', $request['password'])
            ->exists();
        if ($is) {
            $data = DB::table('users')->where('phone', $request['phone'])
                ->where('password', $request['password'])
                ->get()
                ->toArray();
            return response()->json(['data' => $data], 201);
        }

        return response()->json(['data' => '手机号或密码错误'], 422);
    }


    public function code_login(Request $request)
    {
        $is = DB::table('users')->where('api_token', $request['token'])
            ->exists();
        if ($is) {
            $data = DB::table('users')->where('api_token', $request['token'])
                ->get()
                ->toArray();
            return response()->json(['data' => $data], 201);
        }

        return response()->json(['data' => 'TOKEN错误'], 422);
    }


    public function register(Request $request)
    {
        return response()->json(['data' => '验证码错误'], 422);
        $ver_exists = DB::table('users')->where('verification_code',$request['code'])->exists();
//        $ver_exists = 1;
        $phone_exists = DB::table('users')->where('phone', $request['phone'])
            ->where('password','!=','未注册')
            ->exists();
        if ($phone_exists) {
            return response()->json(['data' => '该手机号已被注册'], 422);
//            return '该手机号已被注册';
        }
        if ($ver_exists) {
            $token = str_random(64);
            $id = DB::table('users')->where('phone',$request['phone'])
                ->update(array(
                'name' => str_random(rand(4, 10)),
                'phone' => $request['phone'],
                'password' => $request['password'],
                'remember_token' => '',
                'api_token' => $token,
                'verification_code' => '已完成注册',
            ));
            if ($id) {
                return response()->json(['data' => $token], 201);
            } else {
                return response()->json(['data' => '注册错误，请重试'], 500);
            }
        } else {
            return response()->json(['data' => '验证码错误'], 422);
        }
    }


    public function code(Request $request)
    {
        $phone_exists = DB::table('users')->where('phone', $request['phone'])
            ->where('password','!=','未注册')
            ->exists();
        if ($phone_exists){
            return response()->json(['data' => '手机号已被注册'],422);
        }
        $rand_code = '';
        for($i = 0;$i < 6;$i++) {
            $rand_code = $rand_code.rand(0,9);
        }
        $str = iconv('utf-8','gbk','您好,您的验证码为'.$rand_code.',请保存好不要随意给其他人,YBE-Game在此欢迎您的加入！');
        $url='http://sms.webchinese.cn/web_api/?Uid=dJHYzCbq98pjT&Key=d41d8cd98f00b204e980&smsMob='.$request['phone'].'&smsText='.$str;

        $ch = curl_init();
// curl_init()需要php_curl.dll扩展
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        if ($file_contents == 1){
            $code_exists = DB::table('users')->where('phone', $request['phone'])
                ->where('password','未注册')
                ->exists();
            if($code_exists){
                $id = DB::table('users')->where('phone',$request['phone'])
                    ->update(array(
                    'name' => str_random(6),
                    'phone' => $request['phone'],
                    'verification_code' => $rand_code,
                    'password' => '未注册',
                    'api_token' => str_random(64)
                ));
            }else{
                $id = DB::table('users')->insertGetId(array(
                    'name' => str_random(6),
                    'phone' => $request['phone'],
                    'verification_code' => $rand_code,
                    'password' => '未注册',
                    'api_token' => str_random(64)
                ));
            }

            if ($id){
                return response()->json(['data' => 1],201);
            }
        }
        return response()->json(['data' => $file_contents], 422);
    }


}
