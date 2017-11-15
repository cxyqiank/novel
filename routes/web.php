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


Route::group(['middleware'=>'web','prefix'=>'admin','namespace'=>'admin'],function(){
    //登录界面
    Route::get('login','User@login');
    Route::post('doLogin','User@doLogin');
    Route::any('captcha/{tmp}','User@showCaptcha');
});

Route::group(['prefix'=>'api','namespace'=>'api\controllers'],function(){
    //首页接口
    Route::get('index','v1\IndexAPI@indexAPI');
    //用户
    //注册
    Route::post('user/register','v1\UserAPI@register');
    //发送短信
    Route::post('user/sendMsg','v1\UserAPI@sendMsg');
    //登录
    Route::any('user/login','v1\UserAPI@login');
});

Route::group(['middleware'=>['web','admin.login'],'prefix'=>'admin','namespace'=>'admin'],function (){
    //后台首页
    Route::get('index','Novel@index');
    Route::get('/','Novel@index');

    //小说
    //小说列表
    Route::get('novel/lists','Novel@lists');
    //小说添加界面
    Route::any('novel/add','Novel@add');
    //小说修改界面
    Route::any('novel/update','Novel@update');
    //小说删除
    Route::get('novel/delete','Novel@delete');
    //小说更新界面
    Route::any('novel/addSection/','Section@add');
    Route::any('novel/addSection/doAdd','Section@doAdd');
    //小说信息
    Route::get('novel/info','Novel@info');
    //小说章节
    Route::any('novel/show','Novel@show');

    //banner图
    //banner列表
    Route::get('banner/info','Banner@info');
    //banner修改
    Route::any('banner/up','Banner@update');
    //banner添加
    Route::any('banner/add','Banner@add');
    //banner删除
    Route::get('banner/delete','Banner@delete');

    //公告
    //公告列表
    Route::get('notice/info','Notice@info');
    //公告添加
    Route::any('notice/add','Notice@add');
    //公告修改
    Route::any('notice/edit','Notice@edit');
    //公告删除
    Route::get('notice/delete','Notice@delete');

    //分类
    //分类列表
    Route::get('cart/info','Cart@info');
    //分类添加
    Route::any('cart/add','Cart@add');
    //分类修改
    Route::any('cart/edit','Cart@edit');
    //分类删除
    Route::get('cart/delete','Cart@delete');

    //用户管理
    //用户列表
    Route::get('info','Admin@info');
    //用户添加
    Route::any('add','Admin@add');
    //用户修改
    Route::any('edit','Admin@edit');
    //用户删除
    Route::get('delete','Admin@delete');
    //登出
    Route::get('logout','User@logout');
});

Route::get('/home', 'HomeController@index')->name('home');
