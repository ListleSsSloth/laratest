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
//Auth::routes();
Route::auth();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

//root section
Route::group(['prefix' => 'root', 'middleware' => ['auth','can:root-actions']], function () {
    
    Route::get('/debug', 'Root\DebugController')->name('debug');
       
});

//admin section
Route::group(['prefix' => 'admin', 'middleware' => ['auth','can:admin-actions']], function () {
    //users
    Route::group(['prefix' => 'users'], function () {
        Route::match(['get','post'], '/', 'Admin\UsersController@index')->name('users');
        Route::match(['get','post'], '/add', 'Admin\UsersController@add')->name('users-add');
        Route::match(['get','post'], '/edit/{id}', 'Admin\UsersController@edit')->name('users-edit');
    });

    //roles
    Route::group(['prefix' => 'roles', 'middleware' => 'can:edit-roles'], function () {
        Route::get('/', 'Admin\RolesController@index')->name('roles');
        Route::match(['get','post'], '/add', 'Admin\RolesController@add')->name('roles-add');
        Route::match(['get','post'], '/edit/{id}', 'Admin\RolesController@edit')->name('roles-edit');
    });
});

//welcome page
Route::get('/', function () { return view('/welcome'); })->name('welcome');

//routes for auth users
Route::group(['middleware' => 'auth'], function () {
    
    //demo
    Route::get('/demo1', 'Demo\Demo1Controller@get');

    Route::get('/demo2', 'Demo\Demo2Controller@get');
    Route::post('/demo2', 'Demo\Demo2Controller@post');
    
       
});

