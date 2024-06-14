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
        $searchTerm = $request->input('q');
        $accounts = User::where('name', 'like', '%'.$searchTerm.'%')->get();
        $articles = Article::where('title', 'like', '%'.$searchTerm.'%')->get();
        $accountIds = $accounts->pluck('id')->toArray();
        $articlesByAccounts = Article::whereIn('user_id', $accountIds)->get();
        $articles = $articles->merge($articlesByAccounts)->unique();

        return view('pages.search_result', [
            'accounts' => $accounts,
            'articles' => $articles,
            'title' => 'Search Results',
            'type' => 'accounts',
        ]);
    }
}
