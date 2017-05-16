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

Route::get('/', 'WelcomeController@index');
Route::get('/captcha', 'HomeController@captcha');

Route::get('/auth/login', ['middleware' => 'check.guest', 'uses' => 'AuthController@login']);
Route::post('/auth/login', 'AuthController@loginHandle');
Route::get('/auth/register', ['middleware' => 'check.guest', 'uses' => 'AuthController@register']);
Route::post('/auth/register', 'AuthController@registerHandle');

Route::get('/user', ['middleware' => 'check.user', 'uses' => 'UserController@profile']);
Route::get('/user/instance', ['middleware' => 'check.user', 'uses' => 'UserController@listInstance']);
Route::get('/user/showreinstall', ['middleware' => 'check.user', 'uses' => 'UserController@showReinstall']);
Route::get('/user/showchangepwd', ['middleware' => 'check.user', 'uses' => 'UserController@showChangePwd']);
Route::get('/user/showinstancedetail', ['middleware' => 'check.user', 'uses' => 'UserController@showInstanceDetail']);
Route::get('/user/showstart', ['middleware' => 'check.user', 'uses' => 'UserController@showStart']);
Route::post('/user/instancehandle', ['middleware' => 'check.user', 'uses' => 'UserController@instanceHandle']);
Route::get('/user/getlistinstancejson', ['middleware' => 'check.user', 'uses' => 'UserController@getListInstanceJson']);
Route::get('/user/bindinstance', ['middleware' => 'check.user', 'uses' => 'UserController@getBindInstance']);
Route::post('/user/bindinstance', ['middleware' => 'check.user', 'uses' => 'UserController@bindInstance']);
Route::get('/user/logout', 'UserController@logout');

Route::get('/password/reset', 'PasswordController@reset');
Route::post('/password/reset', 'PasswordController@resetHandle');
Route::get('/password/token/{token}', 'PasswordController@token');
Route::post('/password/token', 'PasswordController@tokenHandle');
