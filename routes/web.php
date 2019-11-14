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

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('expense-category/get', 'ExpenseCategoryController@get');
    Route::get('/users/change-password', 'UserController@changePassword');
    Route::post('/users/change-password', 'UserController@updatePassword');

    Route::group(['middleware' => ['role']], function () {
        Route::get('users/get', 'UserController@get');
        Route::resource('users', 'UserController');

        Route::get('roles/get', 'RoleController@get');
        Route::resource('roles', 'RoleController');

        Route::resource('expense-category', 'ExpenseCategoryController');        
    });
    

    Route::get('expenses/get', 'ExpenseController@get');
    Route::resource('expenses', 'ExpenseController');
    
    Route::get('/home', 'HomeController@index')->name('home');
});



