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

Route::get('/', 'LoginController@index');

//定义商家资源路由
Route::resource('user','UserController');
Route::get('user/show','UserCOntroller@show')->name('user.show');//重写show路由

//定义登录路由
Route::get('login','LoginController@index')->name('login');//登录页面
Route::post('login','LoginController@login')->name('login');//登录功能
Route::get('logout','LoginController@logout')->name('logout');//退出登录功能

//定义菜品分类资源路由
Route::resource('menus','MenuCategoriesController');

//定义菜品资源路由
Route::resource('menu','MenuController');
Route::get('menu/{menu}/status','MenuController@status')->name('status');
//Route::get('menu/{id}/index','MenuController@index')->name('menu.index');
