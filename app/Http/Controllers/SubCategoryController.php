<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function AllSubCategory()
    {
        $subcategories = SubCategory::latest()->get();
        return view();
    }

    public function AddSubCategory()
    {
        $categories = Category::latest()->get();

        return view();
    }

    public function SubCategoryStored(Request $request)
    {
        SubCategory::insert([
            'category_id' => $request->category_name,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = array(
            'message' => 'Sub Category Successfully Added',
            'alert_type' => 'success'
        );

        return redirect()->route()->with($notification);
    }

    public function EditSubCategory($id)
    {
        $categories = Category::latest()->get();
        $subcategories = SubCategory::findOrFail($id);
        return view();
    }

    public function SubCategoryUpdate(Request $request)
    {
        $sub_category_id = $request->id;
        SubCategory::findOrFail($sub_category_id)->update([
            'category_id' => $request->category_name,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = array(
            'message' => 'Sub Category Successfully Updated',
            'alert_type' => 'success'
        );

        return redirect()->route()->with($notification);
    }

    public function SubCategoryDelete($id)
    {
        SubCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Sub Category Successfully Deleted',
            'alert_type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
