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

// Home
Route::get('/', 'Front\HomeController@homePage')->name('home');

// Auth
Auth::routes();

// Verify account
Route::prefix('verify')->group(function ()
{
    Route::get('check/{login}/{token}', 'Auth\VerifyController@verify')->name('auth.verify');
    Route::get('change-email/{login}/{token}', 'Front\Settings\EmailController@updateEmail')->name('auth.change.email');
});

// Auth section
Route::group(['middleware' => ['auth']], function () 
{
    // Account settings
    Route::prefix('settings')->group(function () 
    {
        Route::get('/', 'Front\Settings\DashboardController@index')->name('settings');

        Route::get('password', 'Front\Settings\PasswordController@showForm')->name('change.password');
        Route::post('password', 'Front\Settings\PasswordController@updatePassword');

        Route::get('email', 'Front\Settings\EmailController@showForm')->name('change.email');
        Route::post('email', 'Front\Settings\EmailController@requestNewEmail');
    });
});

// Admin panel
Route::group(['middleware' => ['auth', 'admin']], function () 
{
    Route::get('/acp', 'Admin\AdminController@dashboard')->name('admin.index');
    Route::prefix('/acp')->group(function () 
    {
        Route::resource('users', 'Admin\AccountController', ['except' => ['create', 'destroy']]);
        Route::prefix('/users')->group(function () 
        {
            Route::get('{user}/block', 'Admin\AccountController@blockUserForm')->name('users.block');
            Route::post('{user}/block', 'Admin\AccountController@blockUser');         
        });

        Route::resource('news', 'Admin\NewsController');
    });
});
