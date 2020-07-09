<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gregwar\Captcha\CaptchaBuilder;

class Account extends Controller
{
    //后台登录
    public function login(){
        return view('admins/account/login');
    }

    public function dologin(Request $request){
        $username = $request->username;
        $pwd = $request->pwd;
        $vericode = strtolower($request->vericode);
        session_start();
        $sess_code = strtolower($_SESSION['phrase']);
        if($vericode != $sess_code){
            exit(json_encode(array('code'=>1,'msg'=>'验证码错误')));
        }
        //查询数据库校验用户名和密码
        $res = Auth::attempt(['username'=>$username,'password'=>$pwd]);
        if(!$res){
            exit(json_encode(array('code'=>1,'msg'=>'账号或密码错误')));
        }
        return json_encode(array('code'=>0,'msg'=>'登录成功'));
    }

    //退出
    public function logout()
    {
        Auth::logout();
        return json_encode(['code'=>0,'msg'=>'退出成功']);
    }
    //验证码
    public function vericode(){
        $builder = new CaptchaBuilder;
        $builder->build();
        $builder->output();
        session_start();
        $_SESSION['phrase'] = $builder->getPhrase();
    }
    //
}
