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
Route::post('/autoFile','MenuController@autoFile');//定义上传文件路由
//Route::get('/menu/moreDelete','MenuController@moreDelete');//定义批量删除路由
Route::get('moreDel','MenuController@moreDel')->name('menu.moreDel');

//定义活动路由
Route::get('active','ActiveController@index')->name('active.index');
Route::get('wait','ActiveController@wait')->name('active.wait');

//定义订单路由
Route::get('Order','OrderController@index')->name('order.index');
Route::get('Order/status','OrderController@status');

//更多
Route::get('Mores/index',function(){
   return view('Mores.index');
});

