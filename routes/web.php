<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
//    return view('');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/changePassword','HomeController@showChangePasswordForm');
Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){
    Route::resource('/users','userController')->middleware('can:manage-users');
    Route::resource('/clients','clientController');
    Route::resource('/pets','petController');
    Route::resource('/appointments','appointmentController');
    Route::resource('/profile','profileController');

});


//Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:is-shop')->group(function(){
//    Route::resource('/clients','clientsController')->middleware('can:is-shop');
//});
