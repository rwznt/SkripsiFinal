<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('home', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index']);

Route::get('register', [LoginController::class, 'register'])->name('register')->middleware('guest');
Route::post('register', [LoginController::class, 'register_action'])->name('register.action');

Route::get('login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login_action'])->name('login.action');

Route::get('password', [LoginController::class, 'password'])->name('password');
Route::post('password', [LoginController::class, 'password_action'])->name('password.action');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('profile', [ProfileController::class, 'index'])->middleware('auth');
Route::get('editprofile', [ProfileController::class, 'editprofile']);
Route::post('editprofile', [ProfileController::class, 'update']);

Route::get('create', [ArticleController::class, 'create'])->name('create');
Route::post('create', [ArticleController::class, 'store']);

Route::get('edit/{id}', [ArticleController::class, 'editArticle'])->name('editArticle');
Route::put('edit/{article}', [ArticleController::class, 'updateArticle'])->name('updateArticle');

Route::get('latest', [ArticleController::class, 'index'])->name('updatedArticles');

Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');


Route::get('category/{category}', [ArticleController::class, 'articlesByCategory'])->name('articles.by_category');

Route::middleware('level:admin')->group(function () {
    Route::get('article/review', [ArticleController::class, 'review'])->name('review');
    Route::put('article/review/{article}', [ArticleController::class, 'reviewUp'])->name('articles.review.update');
});
