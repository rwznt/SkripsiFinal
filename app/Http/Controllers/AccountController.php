<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Follow;

class AccountController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $articles = Article::where('user_id', $user->id)->get();

        $followerCount = Follow::followerCount($user);
        $followingCount = Follow::followingCount($user);

        $isOwnProfile = Auth::check() && Auth::user()->id === $user->id;

        return view('user.account', [
            'user' => $user,
            'articles' => $articles,
            'title' => $user->name,
            'followerCount' => $followerCount,
            'followingCount' => $followingCount,
            'isOwnProfile' => $isOwnProfile,
        ]);
    }

    public function follow(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        if (Follow::canFollow($request->user(), $user)) {
            Follow::follow($user);
            return back()->with('success', 'You are now following ' . $user->name);
        }

        return back()->with('error', 'Unable to follow ' . $user->name);
    }

    public function unfollow(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        if ($request->user()->isFollowing($user)) {
            Follow::unfollow($user);
            return back()->with('success', 'You have unfollowed ' . $user->name);
        }

        return back()->with('error', 'You are not following ' . $user->name);
    }
}
