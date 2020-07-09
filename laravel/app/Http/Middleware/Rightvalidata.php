<?php

namespace App\Http\Middleware;

use Closure;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Rightvalidata
{


    public function handle($request, Closure $next)
    {
        $admin = Auth::user();
        $gid = $admin->gid;
        $status = $admin->status;
        if($admin->status==1){
            return $this->_norights($request,'该角色已禁用');
        }
        $group = DB::table('admin_group')->where('gid',$gid)->item();
        if(!$group){
            return $this->_norights($request,'该角色不存在');
        }
        $rights = [];
        if($group['rights']){
            $rights = json_decode($group['rights']);
        }
        $res = $request->route()->action['controller'];
        $res = explode('\\',$res);
        $res = array_pop($res);
        $res = explode('@',$res);
        $cur_menu = DB::table('admin_menu')->where('controller',$res[0])->where('action',$res[1])->item();
        if(!$cur_menu)
        {
            return $this->_norights($request,'该功能不存在');
        }
        if($cur_menu['status'])
        {
            return $this->_norights($request,'该功能已被禁用');
        }
        if(!in_array($cur_menu['mid'],$rights))
        {
           return $this->_norights($request,'权限不足');
        }
        return $next($request);
    }

    private function _norights($request,$msg)
    {
        if($request->ajax())
        {
            return response(json_encode(['code'=>1,'msg'=>$msg]),200);
        }
        return response($msg,200);
    }
}
