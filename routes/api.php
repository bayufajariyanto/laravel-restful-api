<?php

use Illuminate\Http\Request;

Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::get('users', 'UserController@users');
Route::get('users/profile', 'UserController@profile')->middleware('auth:api');