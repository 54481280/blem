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

Route::get('/','IndexController@index');

Route::post('/autoFile','ShopCategoriesController@autoFile');//定义上传文件路由

//定义登录路由
Route::get('login','LoginController@index')->name('login');//登录页面
Route::post('login','LoginController@login')->name('login');//登录功能
Route::get('logout','LoginController@logout')->name('logout');//退出登录功能

//权限

/*
 * 查看管理员列表   添加管理员   删除管理员   更新管理员角色
 * 查看商家分类列表   修改商家分类状态    添加商家分类   删除商家分类 修改商家分类
 * 查看商家信息列表   新增商家 查看商家详细信息   修改商家状态    修改商家信息   删除商家
 * 查看商家账号列表   修改商家账号状态   重置商家账号密码
 * 查看商家活动列表   添加商家活动 修改商家活动
 * 查看会员列表   添加会员   修改会员状态   查看会员详细信息
 * 查看权限列表   添加权限   修改权限   删除权限
 * 查看角色列表   添加角色   修改角色  删除角色
 * 查看菜单列表   修改菜单   删除菜单  添加菜单
 */


//商家分类模块
Route::group(['middleware' => ['permission:查看商家分类列表']], function () {
    Route::resource('shop','ShopCategoriesController');
    Route::get('shop/{shop}/status/','ShopCategoriesController@status')->name('shop.status');//商家分类状态路由
});


//查看商家信息列表
Route::group(['middleware' => ['permission:查看商家信息列表']], function () {
    Route::resource('shops','ShopsController');
    Route::get('shops/{shop}/status/','ShopsController@status')->name('shops.status');//商家分类状态路由
});

//查看会员列表
Route::group(['middleware' => ['permission:查看会员列表']], function () {
    Route::resource('member','MemberController');
    Route::get('member/{member}/status/','MemberController@status')->name('member.status');
});

//查看商家账号列表
Route::group(['middleware' => ['permission:查看商家账号列表']], function () {
    Route::resource('user','UsersController');
    Route::get('user/{user}/status/','UsersController@status')->name('user.status');//商家账户状态路由
});

//查看商家活动列表
Route::group(['middleware' => ['permission:查看商家活动列表']], function () {
    Route::resource('active','ActiveController');
});

//查看权限列表
Route::group(['middleware' => ['permission:查看权限列表']], function () {
    Route::resource('permission','PermissionController');
});

//查看角色列表
Route::group(['middleware' => ['permission:查看角色列表']], function () {
    Route::resource('role','RoleController');
});

//查看菜单列表
Route::group(['middleware' => ['permission:查看菜单列表']], function () {
    Route::resource('nav','NavController');
});

//查看系统数据
Route::group(['middleware' => ['permission:查看系统数据']], function () {
    Route::get('/index','IndexController@index');
});

//管理员模块
Route::group(['middleware' => ['permission:查看管理员列表']], function () {
    Route::resource('admin','AdminController');
    Route::get('admin/{admin}/del','AdminController@del')->name('admin.del');
});

Route::get('/admin/{admin}','AdminController@show')->name('admin.show');
Route::delete('/admin/{admin}','AdminController@destroy')->name('admin.destroy');

//邮件模板路由
Route::get('/email',function(){
   return view('Email.index');
});

//抽奖模块
Route::group(['middleware' => ['permission:查看抽奖列表']], function () {
    Route::resource('event','EventController');
    Route::get('/event/{event}/prize','EventController@prize')->name('event.prize');//添加抽奖商品
    Route::post('/event/{event}/storePrize','EventController@storePrize')->name('event.storePrize');//添加抽奖商品
    Route::get('/event/{event}/lottery','EventController@lottery')->name('event.lottery');//开奖

});











