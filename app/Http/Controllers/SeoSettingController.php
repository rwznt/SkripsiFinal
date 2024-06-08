<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoSetting;

class SeoSettingController extends Controller
{
    public function SeoSettingUpdate()
    {
        $seo = SeoSetting::findOrFail(1);
        return view();
    }

    public function SeoUpdate(Request $request)
    {
        $seo_id = $request->id;

        SeoSetting::findOrFail()->update([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_author' => $request->meta_author,
            'meta_keyword' => $request->meta_keyword
        ]);

        $notification = array(
            'message' => 'SEO Successfully Updated',
            'alert_type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
