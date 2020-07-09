<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Admin extends Controller
{
    public function index(){
        $data['lists'] = DB::table('admin')->lists();
        $res = DB::table('admin_group')->select('gid','title')->cates('gid');
        $data['title'] = $res;
        return view('/admins/admin/index',$data);
    }
    //添加管理员
    public function add(){
        $data['group'] = DB::table('admin_group')->select('gid','title')->lists();
        return view('/admins/admin/add',$data);
    }
    //更新管理员信息
    public function edit(Request $req){
        $aid = $req->aid;
        $data['list'] = DB::table('admin')->where('id',$aid)->item();
        $data['group'] = DB::table('admin_group')->select('gid','title')->lists();
        return view('admins/admin/edit',$data);
    }
    //保存账户
    public function save(Request $request){
        $aid = $request->aid;
        $data['gid'] = $request->gid;
        $data['real_name'] = $request->real_name;
        $data['phone'] = $request->phone;
        $data['status'] = $request->status=='on'?0:1;
        $pwd = $request->pwd;
        $pwd1 = $request->pwd1;

        if($aid == 0)
        {
            $data['add_time'] = time();
            $data['username'] = $request->username;
            if($data['username']==''){
                exit(json_encode(['code'=>1,'msg'=>'用户名不能为空']));
            }
            if($pwd==''){
                exit(json_encode(['code'=>1,'msg'=>'密码不能为空']));
            }
            if($pwd1==''){
                exit(json_encode(['code'=>1,'msg'=>'请确认密码']));
            }
            if($data['gid']==''){
                exit(json_encode(['code'=>1,'msg'=>'用户角色不能为空']));
            }
            if($data['real_name']==''){
                exit(json_encode(['code'=>1,'msg'=>'真实姓名不能为空']));
            }
            if($data['phone']==''){
                exit(json_encode(['code'=>1,'msg'=>'电话号码不能为空']));
            }
            if(!is_int($data['phone'])){
                exit(json_encode(['code'=>1,'msg'=>'电话号码错误']));
            }
            if($pwd!=$pwd1){
                exit(json_encode(['code'=>1,'msg'=>'两次密码不一致']));
            }
            $data['password'] = password_hash($pwd,PASSWORD_DEFAULT);
            $result = DB::table('admin')->where('username',$data['username'])->first();
            if($result){
                exit(json_encode(['code'=>1,'msg'=>'用户名已注册']));
            }
            $result = DB::table('admin')->insert($data);
            if($result==1){
                exit(json_encode(['code'=>0,'msg'=>'添加成功']));
            }
            exit(json_encode(['code'=>1,'msg'=>'添加失败']));
        }else{
            if($pwd!=$pwd1){
                exit(json_encode(['code'=>0,'msg'=>'两次密码不一致']));
            }elseif($pwd!=''){
                $data['password'] = password_hash($pwd,PASSWORD_DEFAULT);
            }
            DB::table('admin')->where('id',$aid)->update($data);
            exit(json_encode(['code'=>0,'msg'=>'更新成功']));
        }
    }
    //删除账户
    public function del(Request $request){
        $id = (int)$request->aid;
        DB::table('admin')->where('id',$id)->delete();
        exit(json_encode(['code'=>0,'msg'=>'删除成功']));
    }
}
