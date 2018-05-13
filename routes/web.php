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

Route::group(['prefix' => 'auth'], function () {
    Auth::routes();
    Route::get(
        'register',
        function (Request $request) {
            abort(404);
        }
    )->name('register');
    Route::post(
        'register',
        function (Request $request) {
            abort(404);
        }
    );
    Route::get('login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
    Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::delete('/home', 'HomeController@deleteAccount');
