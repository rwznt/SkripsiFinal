<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $articles = Article::latest()->take(3)->get();
        $title = 'Home';
        return view('pages.home', compact('categories', 'articles', 'title'));
    }

    public function tutorial()
    {
        $title = "Tutorial";
        return view('pages.tutorial', compact('title'));
    }

    public function setFromTutorial()
    {
        if (Auth::check()) {
            return redirect()->route('create');
        } else {
            session(['fromTutorial' => true, 'fromLogin' => true]);
            return redirect()->route('login');
        }
    }

    public function notifications()
    {
        $title = "Notifications";
        if(Auth::check()) {
            $notifications = Auth::user()->notifications;
        } else {
            $notifications = [];
        }
        return view('pages.notifications', compact('title', 'notifications'));
    }
}
