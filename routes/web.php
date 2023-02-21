<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\MusicController;
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

Route::controller(MusicController::class)->group(function () {
    Route::get('/', 'top')->name('top');
    Route::get('/post', 'post')->name('post')->middleware('auth');
    Route::post('/confirm', 'confirm')->name('confirm')->middleware('auth');
    Route::post('/complete', 'complete')->name('complete')->middleware('auth');
    Route::post('/like', 'like')->name('like');
});
Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/logincomplete', 'logincomplete')->name('logincomplete');
    Route::get('/passwordreset', 'passwordreset')->name('passwordreset');
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/register', 'register')->name('register');
    Route::get('/logout', 'logout')->name('logout');
});
