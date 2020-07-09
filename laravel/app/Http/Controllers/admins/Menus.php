<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Gregwar\Captcha\CaptchaBuilder;

class Menus extends Controller
{
    public function index()
    {
        $data['lists'] = DB::table('admin_menu')->where('pid',0)->lists();
        return view('admins/menus/index',$data);
    }
}
