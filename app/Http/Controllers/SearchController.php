<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');

        if (!$keyword) {
            return view('pages.search_result', [
                'users' => collect(),
                'articles' => collect(),
                'title' => 'Search Results',
                'keyword' => $keyword,
            ]);
        }

        $users = User::where('name', 'like', '%' . $keyword . '%')
                     ->orWhereHas('articles', function ($query) use ($keyword) {
                         $query->where('title', 'like', '%' . $keyword . '%');
                     })
                     ->get();

        $articles = Article::where('title', 'like', '%' . $keyword . '%')
                           ->orWhereHas('user', function ($query) use ($keyword) {
                               $query->where('name', 'like', '%' . $keyword . '%');
                           })
                           ->get();

        return view('pages.search_result', [
            'users' => $users,
            'articles' => $articles,
            'title' => 'Search Results',
            'keyword' => $keyword,
        ]);
    }
}

