<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['middleware' => 'auth', function () {
    return redirect('home');
}]);

Route::get('/home', ['middleware' => 'auth', function () {
    return view('home');
}]);

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

//独立的搜索服务
Route::any('company/search', 'Management\CompanyController@getSearch');
Route::any('watch/search', 'Management\WatchController@getSearch');
Route::any('warning/search', 'Management\WarningController@getSearch');

//手表激活服务
Route::any('watch/activate', 'Management\WatchController@getActivate');

//手表批量导入
Route::get('watch/multiple-create', 'Management\WatchController@getMultipleCreate');
Route::post('watch/multiple-create', 'Management\WatchController@postMultipleCreate');

//高德地图模块
Route::get('warning/gaode', 'Management\WarningController@getGaode');

//发送短信服务
Route::get('watch/send-message-to-company', 'Management\WatchController@getSendMessageToCompany');
Route::get('watch/send-message-to-user', 'Management\WatchController@getSendMessageToUser');


//管理后台，增删改查功能
Route::resource('watch', 'Management\WatchController');//TODO 手表管理
Route::resource('company', 'Management\CompanyController');//TODO 企业账号管理
Route::resource('warning', 'Management\WarningController');//TODO 报警管理


Route::controller('api', 'Api\MobileAppController');//TODO 手机app接口