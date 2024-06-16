<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('register', [LoginController::class, 'register'])->name('register')->middleware('guest');
Route::post('register', [LoginController::class, 'register_action'])->name('register.action');

Route::get('login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login_action'])->name('login.action');

Route::get('latest', [ArticleController::class, 'index'])->name('articles.index');

Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('category/{category}', [ArticleController::class, 'articlesByCategory'])->name('articles.by_category');

Route::get('/user/{id}', [AccountController::class, 'show'])->name('user.detail');

Route::get('/search', [SearchController::class, 'index'])->name('search.result');

Route::middleware(['auth'])->group(function () {
Route::get('/review', [ArticleController::class, 'review'])->name('review');
Route::match(['get', 'post'], 'article/{id}/like', [ArticleController::class, 'like'])->name('article.like');
Route::match(['get', 'post'], 'article/{id}/unlike', [ArticleController::class, 'unlike'])->name('article.unlike');
Route::match(['post', 'put'], 'article/{id}/review/update', [ArticleController::class, 'updateReview'])->name('article.review.update');
Route::get('password', [LoginController::class, 'password'])->name('password');
Route::post('password', [LoginController::class, 'password_action'])->name('password.action');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('profile', [ProfileController::class, 'index'])->middleware('auth');
Route::get('editprofile', [ProfileController::class, 'editprofile']);
Route::post('editprofile', [ProfileController::class, 'update']);

Route::get('/create', [ArticleController::class, 'create'])->name('create');
Route::post('/store', [ArticleController::class, 'store'])->name('store');

Route::delete('/article/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
Route::match(['get', 'post'], 'users/{user}/follow', [UserController::class, 'follow'])->name('users.follow');
Route::match(['get', 'post'], 'users/{user}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');

Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::match(['get', 'put'], '/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
});
