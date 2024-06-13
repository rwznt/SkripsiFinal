<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'categories' => Category::all(),
            'title' => 'Home'
        ]);
    }
}
