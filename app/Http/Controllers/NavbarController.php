<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function render()
    {
        $notifications = Notification::where('user_id', Auth::id())->latest()->get();
        dd($notifications);
        return view('layout.app', ['notifications' => $notifications]);
    }
}
