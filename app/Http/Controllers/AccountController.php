<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;

class AccountController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $articles = Article::where('user_id', $user->id)->get();

        return view('user.account', [
            'user' => $user,
            'articles' => $articles,
            'title' => $user->name
        ]);
    }
}
