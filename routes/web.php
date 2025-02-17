<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('user/search', [UserController::class, 'index'])->name('user.search');
Route::resource('user', UserController::class);

Route::get('category/search', [CategoryController::class, 'index'])->name('category.search');
Route::get('category/select2', [CategoryController::class, 'getSelect2Data'])->name('category.select2');
Route::resource('category', CategoryController::class);

Route::get('book/search', [BookController::class, 'index'])->name('book.search');
Route::resource('book', BookController::class);
