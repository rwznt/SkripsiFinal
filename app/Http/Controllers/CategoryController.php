<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $categories = Category::latest()->get();
        return view();
    }
}
