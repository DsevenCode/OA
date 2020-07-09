<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

//后台主页
class Home extends Controller
{
    public function index(){
        $admin = Auth::user();
        $id = $admin->id;
        $data['admin'] = DB::table('admin')->where('id',$id)->item();
        $data['menus'] = DB::table('admin_menu')->where('pid',0)->where('ishidden',0)->where('status',0)->get()->all();
        foreach($data['menus'] as $key=>$val){
            $childs = DB::table('admin_menu')->where('pid',$val->mid)->where('ishidden',0)->where('status',0)->get()->all();
            $data['menus'][$key]->child = $childs;
        }
        return view('/admins/home/index',$data);
    }

    public function welcome(){
        return view('/admins/home/welcome');
    }
}
