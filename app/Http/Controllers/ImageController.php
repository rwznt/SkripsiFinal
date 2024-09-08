<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $image = $request->file('image');
    $imageName = time().'.'.$image->getClientOriginalExtension();
    $image->move(public_path('images'), $imageName);

    return response()->json(['url' => '/images/'.$imageName]);
    }
}
