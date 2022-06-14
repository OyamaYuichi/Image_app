<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register')->name('register');
// ログイン
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
// ログアウト
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
// ログインユーザー
Route::get('/user', function() {
  return Auth::user();
})->name('user');
// 写真詳細
// Route::get('/user/{id}', 'App\Http\Controllers\UserController@show')->name('user.show');


// 写真一覧
Route::get('/photos', 'App\Http\Controllers\PhotoController@index')->name('photo.index');
// 写真詳細
Route::get('/photos/{id}', 'App\Http\Controllers\PhotoController@show')->name('photo.show');
// 写真投稿
Route::post('/photos', 'App\Http\Controllers\PhotoController@create')->name('photo.create');
// コメント
Route::post('/photos/{photo}/comments', 'App\Http\Controllers\PhotoController@addComment')->name('photo.comment');
// いいね
Route::put('/photos/{id}/like', 'App\Http\Controllers\PhotoController@like')->name('photo.like');
// いいね解除
Route::delete('/photos/{id}/like', 'App\Http\Controllers\PhotoController@unlike');
Route::delete('/photos/{id}/delete', 'App\Http\Controllers\PhotoController@delete');
// トークンリフレッシュ
Route::get('/reflesh-token', function (Illuminate\Http\Request $request) {
  $request->session()->regenerateToken();

  return response()->json();
});
