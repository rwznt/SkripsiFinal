<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $title = 'Profile';

        $articles = Article::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->paginate(20);

        return view('user.profile', compact('user', 'title'));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('user.editprofile', [
            'user' => $user,
            'title' => 'Edit Profile',
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'nohp' => 'nullable|string|max:20',
            'gender' => 'required|in:L,P',
            'date_of_birth' => 'nullable|date_format:Y-m-d',
            'address' => 'nullable|string|max:500',
        ]);

        $user = User::find(Auth::user()->id);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete('profile_image/' . $user->image);
            }

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->storeAs('public/profile_image', $imageName);

            $user->image = $imageName;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nohp = $request->nohp;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->address = $request->address;
        $user->save();

        if (Session::has('just_registered')) {
            Session::forget('just_registered'); // Clear the session variable
            return redirect('/')->with('success', 'Profile updated successfully!'); // Redirect to home
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}

