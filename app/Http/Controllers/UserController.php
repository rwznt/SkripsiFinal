<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show(User $user)
    {
        $articles = $user->articles()->latest()->get();
        $title = $user->name . "'s Profile";
        $isOwnProfile = Auth::check() && Auth::user()->id === $user->id;
        $followerCount = Follow::followerCount($user);
        $followingCount = Follow::followingCount($user);

        return view('user.account', compact('user', 'title', 'articles', 'followerCount', 'followingCount', 'isOwnProfile'));
    }
}
