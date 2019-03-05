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

Route::get('/','LoginController@index');

//定义商家分类路由
Route::resource('shop','ShopCategoriesController');
Route::get('shop/{shop}/status/','ShopCategoriesController@status')->name('shop.status');//商家分类状态路由
Route::post('/autoFile','ShopCategoriesController@autoFile');//定义上传文件路由

//定义商家信息路由
Route::resource('shops','ShopsController');
Route::get('shops/{shop}/status/','ShopsController@status')->name('shops.status');//商家状态路由

//定义商家用户路由
Route::resource('user','UsersController');
Route::get('user/{user}/status/','UsersController@status')->name('user.status');//商家账户状态路由

//定义管理员资源路由
Route::resource('admin','AdminController');

//定义登录路由
Route::get('login','LoginController@index')->name('login');//登录页面
Route::post('login','LoginController@login')->name('login');//登录功能
Route::get('logout','LoginController@logout')->name('logout');//退出登录功能

//定义活动资源路由
Route::resource('active','ActiveController');

//定义会员资源路由
Route::resource('member','MemberController');
Route::get('member/{member}/status/','MemberController@status')->name('member.status');//商家状态路由





