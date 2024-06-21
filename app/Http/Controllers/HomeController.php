<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $articles = Article::latest()->paginate(10);
        $title = 'Home';
        return view('pages.home', compact('categories', 'articles', 'title'));
    }
}
