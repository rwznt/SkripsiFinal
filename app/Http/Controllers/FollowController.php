<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        if (Follow::follow($user)) {

            return redirect()->back()->with('success', 'You are now following ' . $user->name);
        } else {
            return redirect()->back()->with('error', 'Failed to follow ' . $user->name);
        }
    }

    public function unfollow(User $user)
    {
        if (Follow::unfollow($user)) {
            return redirect()->back()->with('success', 'You have unfollowed ' . $user->name);
        } else {
            return redirect()->back()->with('error', 'Failed to unfollow ' . $user->name);
        }
    }
}
