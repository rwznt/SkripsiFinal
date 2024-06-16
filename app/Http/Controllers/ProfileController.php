<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
    	$user = User::where('id', Auth::user()->id)->first();

    	return view('user.profile', compact('user'),[
            'title' => 'Profile'
        ]);
    }

    public function editprofile(){

        $user = User::where('id', Auth::user()->id)->first();
        return view('user.editprofile',compact('user'),[
            'title' => 'Edit Profile',
        ]);
    }

    public function update(Request $request)
    {
    	 $this->validate($request, [
            'name'  => 'required',
            'email' => 'required',
            'nohp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

    	$user = User::where('id', Auth::user()->id)->first();

        if (!$user) {
            return redirect('editprofile')->with('error', 'User not found');
        }

    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->nohp = $request->nohp;
    	$user->address = $request->address;

    	$user->update();

    	return redirect('profile')->with('success', 'Profile updated successfully');
    }

    public function showAuthenticatedUser()
    {
        $user = Auth::user();
        return view('profile.account', ['user' => $user]);
    }
}
