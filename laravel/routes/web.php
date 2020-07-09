<?php

use Illuminate\Support\Facades\Route;

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
//    echo date('Y-m-d H:m:s');
});

Route::get('/admins/account/login','admins\Account@login')->name('login');
Route::get('/admins/account/logout','admins\Account@logout');
Route::get('/admins/account/vericode','admins\Account@vericode');
Route::post('/admins/account/dologin','admins\Account@dologin');
Route::namespace('admins')->middleware(['auth','rights'])->group(function(){
    Route::get('/admins/home/index','Home@index');
    Route::get('/admins/home/welcome','Home@welcome');
    Route::get('/admins/admin/index','Admin@index');
    Route::get('/admins/admin/add','Admin@add');
    Route::post('/admins/admin/save','Admin@save');
    Route::post('/admins/admin/del','Admin@del');
    Route::get('/admins/admin/edit','Admin@edit');
    //权限菜单
    Route::get('admins/menus/index','Menus@index');
});


