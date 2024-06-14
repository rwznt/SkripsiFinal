<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(User $user)
    {
        $articles = $user->articles()->latest()->get();
        return view('users.show', compact('user', 'articles'));
    }

    /*
    public function follow(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        if ($authUser->isFollowing($user)) {
            return back()->with('error', 'You are already following ' . $user->name);
        }

        $authUser->followees()->attach($user);
        return back()->with('success', 'You are now following ' . $user->name);
    }

    public function unfollow(User $user)
    {
        auth()->user()->followees()->detach($user);
        return back()->with('success', 'You have unfollowed ' . $user->name);
    }
        */
}
