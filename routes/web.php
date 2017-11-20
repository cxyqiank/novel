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
Route::get('login','admin\Admin@login')->name('login');
Route::group(['middleware'=>'web','prefix'=>'admin','namespace'=>'admin'],function(){
    //登录界面
    Route::post('doLogin','Admin@doLogin');
    Route::match(['get','post'],'captcha/{tmp}','Admin@showCaptcha');
});

Route::group(['namespace'=>'api\controllers'],function(){
    //首页接口
    Route::get('index','v1\IndexAPI@indexAPI');
    Route::match(['get','post'],'index-notice','v1\IndexAPI@indexNotice');
    Route::match(['get','post'],'index-banner','v1\IndexAPI@indexBanner');
    Route::match(['get','post'],'index-hotRead','v1\IndexAPI@indexHot');
    Route::get('index-news','v1\IndexAPI@indexNews');
    Route::get('index-descs','v1\IndexAPI@indexDescs');

    //分类页面接口
    Route::get('cart-index','v1\CartAPI@index');
    //书架
    Route::post('shelf','v1\Shelf@shelf');
    //左边栏
    Route::get('hotAuthor','v1\IndexAPI@hotAuthor');
    Route::post('collectors','v1\Shelf@collectors');
    Route::post('contentRead','v1\NovelAPI@contentRead');
    //用户
    //注册
    Route::match(['get','post'],'user-register','v1\UserAPI@register');
    //发送短信
    Route::match(['get','post'],'user-sendMsg','v1\UserAPI@sendMsg');

    //登录
    Route::match(['get','post'],'user-login','v1\UserAPI@login');
});

Route::group(['middleware'=>['web','admin.login'],'prefix'=>'admin','namespace'=>'admin'],function (){
    //后台首页

    Route::get('index','Novel@index');
    Route::get('/','Novel@index');
Route::group(['middleware'=>'can:pernovel'],function(){
    //小说
    //小说列表
    Route::get('novel/lists','Novel@lists');
    //小说添加界面
    Route::match(['get','post'],'novel/add','Novel@add');
    //小说修改界面
    Route::match(['get','post'],'novel/update','Novel@update');
    //小说删除
    Route::get('novel/delete','Novel@delete');
    //批量删除
    Route::post('novel/multiDel','Novel@multiDel');
    //小说更新界面
    Route::match(['get','post'],'novel/addSection/','Section@add');
    Route::match(['get','post'],'novel/addSection/doAdd','Section@doAdd');
    //小说信息
    Route::match(['get','post'],'novel/info','Novel@info');
    //小说章节
    Route::match(['get','post'],'novel/show','Novel@show');
});
Route::group(['middleware'=>'can:info'],function() {
    //banner图
    //banner列表
    Route::get('banner/info', 'Banner@info');
    //banner修改
    Route::match(['get', 'post'], 'banner/up', 'Banner@update');
    //banner添加
    Route::match(['get', 'post'], 'banner/add', 'Banner@add');
    //banner删除
    Route::get('banner/delete', 'Banner@delete');
    //banner批量删除
    Route::post('banner/multiDel', 'Banner@multiDel');

    //公告
    //公告列表
    Route::get('notice/info', 'Notice@info');
    //公告添加
    Route::match(['get', 'post'], 'notice/add', 'Notice@add');
    //公告修改
    Route::match(['get', 'post'], 'notice/edit', 'Notice@edit');
    //公告删除
    Route::get('notice/delete', 'Notice@delete');

    //分类
    //分类列表
    Route::get('cart/info', 'Cart@info');
    //分类添加
    Route::match(['get', 'post'], 'cart/add', 'Cart@add');
    //分类修改
    Route::match(['get', 'post'], 'cart/edit', 'Cart@edit');
    //分类删除
    Route::get('cart/delete', 'Cart@delete');
});
Route::group(['middleware'=>'can:users'],function(){
    //用户管理
    //用户列表
    Route::get('info', 'Admin@info');
    //用户添加
    Route::match(['get', 'post'], 'add', 'Admin@add');
    //用户修改
    Route::match(['get', 'post'], 'edit', 'Admin@edit');
    //用户删除
    Route::get('delete', 'Admin@delete');
    //用户分配角色
    Route::get('grant/{user}', 'Admin@grant');
    Route::post('store/{user}', 'Admin@store');

    //角色管理
    Route::get('role-info', 'Role@info');
    Route::match(['get', 'post'], 'role-add', 'Role@add');
    Route::match(['get', 'post'], 'role-edit', 'Role@edit');
    Route::get('role-delete', 'Role@delete');

    //权限分配
    Route::get('role/grant/{role}', 'Role@grant');
    Route::post('role/store/{role}', 'Role@store');
//    Route::match(['get','post'],'send-permission','Role@permission');


    //权限管理
    Route::get('permission', 'Permission@info');
    Route::match(['get', 'post'], 'permission/add', 'Permission@add');
    Route::match(['get', 'post'], 'permission/edit', 'Permission@edit');
    Route::get('permission/delete', 'Permission@delete');
});

    //登出
    Route::get('logout','Admin@logout')->name('logout');
});

