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

// デフォルト
// Route::get('/', function () {
//     return view('welcome');
// });

// breezeにより自動生成
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// 利用規約ページ
Route::get('/terms', function () {
    return view('welcome');
});

// お知らせページ
Route::get('/news', function () {
    return view('welcome');
});

// breezeにより自動生成
require __DIR__.'/auth.php';
