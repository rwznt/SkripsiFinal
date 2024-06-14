<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show($userId)
    {
        $user = User::findOrFail($userId); // Fetch the user by ID
        $articles = $user->articles; // Assuming articles is a relationship defined on User model

        return view('users.show', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }
}
