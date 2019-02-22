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

Route::get('/','ShopCategoriesController@index');

//定义商家分类路由
Route::resource('shop','ShopCategoriesController');
Route::get('shop/{shop}/status/','ShopCategoriesController@status')->name('shop.status');//商家分类状态路由

//定义商家信息路由
Route::resource('shops','ShopsController');
Route::get('shops/{shop}/status/','ShopsController@status')->name('shops.status');//商家状态路由

//定义商家用户路由
Route::resource('user','UsersController');

//定义管理员资源路由
Route::resource('admin','AdminController');
