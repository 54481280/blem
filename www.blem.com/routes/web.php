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
Route::post('/api/regist/','ApiController@regist');//注册接口
Route::get('/api/sms/','ApiController@sms');//注册接口
Route::get('/api/rds/','ApiController@rds');//手机验证码接口
Route::post('/api/login/','ApiController@login');//登录接口
Route::post('/api/addAddress/','ApiController@addAddress');//保存新增地址接口
Route::get('/api/address/','ApiController@address');//保存新增地址接口
Route::get('/api/addressList/','ApiController@addressList');//地址列表接口
Route::post('/api/editAddress/','ApiController@editAddress');//修改地址接口
Route::post('/api/addCart/','ApiController@addCart');//保存购物车地址接口
Route::get('/api/cart/','ApiController@cart');//保存购物车地址接口
Route::post('/api/addorder/','ApiController@addorder');//添加订单接口
