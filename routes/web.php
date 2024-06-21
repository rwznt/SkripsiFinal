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
use App\Http\Controllers\NotificationController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

//Session related routes
Route::get('register', [LoginController::class, 'register'])->name('register')->middleware('guest');
Route::post('register', [LoginController::class, 'register_action'])->name('register.action');
Route::get('login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login_action'])->name('login.action');

//Article related routes (public)
Route::get('latest', [ArticleController::class, 'index'])->name('articles.index');
Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('category/{category}', [ArticleController::class, 'articlesByCategory'])->name('articles.by_category');

//User related routes (public)
Route::get('/user/{id}', [AccountController::class, 'show'])->name('user.detail');

Route::get('/search', [SearchController::class, 'index'])->name('search.result');

Route::fallback(function () {
    return view('error.404');
});

Route::middleware(['auth'])->group(function () {

    //Login related routes
    Route::get('password', [LoginController::class, 'password'])->name('password');
    Route::post('password', [LoginController::class, 'password_action'])->name('password.action');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    //Profile related routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/editprofile', [ProfileController::class, 'edit'])->name('editprofile');
    Route::post('editprofile', [ProfileController::class, 'update'])->name('updateprofile');

    //Article related routes
    Route::get('/review', [ArticleController::class, 'review'])->name('review');
    Route::match(['get', 'post'], 'article/{id}/like', [ArticleController::class, 'like'])->name('article.like');
    Route::match(['get', 'post'], 'article/{id}/unlike', [ArticleController::class, 'unlike'])->name('article.unlike');
    Route::match(['post', 'put'], 'article/{id}/review/update', [ArticleController::class, 'updateReview'])->name('article.review.update');
    Route::get('/create', [ArticleController::class, 'create'])->name('create');
    Route::post('/store', [ArticleController::class, 'store'])->name('store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::match(['get', 'put'], '/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/article/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    //Comment related routes
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{id}/reply', [CommentController::class, 'reply'])->name('comments.reply');

    //User related routes
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('markAsRead');

    //Follow related routes
    Route::post('/user/{userId}/follow', [AccountController::class, 'follow'])->name('user.follow');
    Route::delete('/user/{userId}/unfollow', [AccountController::class, 'unfollow'])->name('user.unfollow');

});
