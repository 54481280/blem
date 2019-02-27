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


/*
 * 定义接口路由
 */

Route::get('/api/businessList/','ApiController@businessList');//获得商家列表接口
Route::get('/api/business/','ApiController@business');//获得指定商家接口
