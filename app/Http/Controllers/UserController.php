<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $articles = $user->articles()->latest()->get();
        $title = $user->name . "'s Profile";
        $isOwnProfile = Auth::check() && Auth::user()->id === $user->id;
        $followerCount = Follow::followerCount($user);
        $followingCount = Follow::followingCount($user);
        $isFollowing = Follow::isFollowing(Auth::user(), $user);

        return view('user.account', compact('user', 'title', 'articles',
        'followerCount', 'followingCount', 'isOwnProfile',
        'isFollowing', 'followers', 'following'));
    }

    public function followList(User $user, Request $request)
    {
        $keyword = $request->input('keyword');
        $followers = $user->followers()->when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%");
        })->get();
        $following = $user->following()->when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%");
        })->get();
        $followerCount = $user->followers()->count();
        $followingCount = $user->following()->count();
        $title = $user->name . "'s Follow List";

        return view('user.follow-list', compact('user', 'followers', 'following',
            'followerCount', 'followingCount', 'title', 'keyword'));
    }

}
