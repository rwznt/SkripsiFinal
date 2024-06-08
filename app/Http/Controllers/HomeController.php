<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function render()
    {
        return view('pages.home', [
            'title' => 'Articreate'
        ]);
    }
}
