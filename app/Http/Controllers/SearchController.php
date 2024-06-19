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
            // Handle case where search term is empty or not provided
            return view('pages.search_result', [
                'users' => collect(), // Empty collection
                'articles' => collect(), // Empty collection
                'title' => 'Search Results',
                'keyword' => $keyword,
            ]);
        }

        // Search users by name and by associated articles
        $users = User::where('name', 'like', '%' . $keyword . '%')
                     ->orWhereHas('articles', function ($query) use ($keyword) {
                         $query->where('title', 'like', '%' . $keyword . '%');
                     })
                     ->get();

        // Search articles by title and by associated user names
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

