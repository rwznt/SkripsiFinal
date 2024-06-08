<?php

namespace App\Http\Controllers;
use App\Http\Models\User;
use Illuminate\Http\Request;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
    	$user = ModelsUser::where('id', Auth::user()->id)->first();

    	return view('user.profile', compact('user'),[
            'title' => 'Profile'
        ]);
    }

    public function editprofile(){

        $user = ModelsUser::where('id', Auth::user()->id)->first();
        return view('user.editprofile',compact('user'),[
            'title' => 'Edit Profile',
        ]);
    }

    public function update(Request $request)
    {
    	 $this->validate($request, [
            'name'  => 'required',
            'email' => 'required'
        ]);

    	$user = ModelsUser::where('id', Auth::user()->id)->first();
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->nohp = $request->nohp;
    	$user->address = $request->address;

    	$user->update();

    	return redirect('editprofile');
    }
}
