<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\SubCategory;
use Intervention\Image\Facades\Image;


class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view();
    }

    public function createArticle()
    {
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();

        return view();
    }

    public function store(Request $request)
    {
        $image      = $request->file('image');

        $name_gen   = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

         // resize() dikarenakan sudah memakai package Image Intervention.

        Image::make($image)->resize(784,436)->save('upload/news/'.$name_gen);

        $save_url = 'upload/news/'.$name_gen;

        Article::insert([

            'category_id'               => $request->category_id,
            'subcategory_id'            => $request->subcategory_id,
            'user_id'                   => $request->user_id,
            'news_title'                => $request->news_title,
            'news_title_slug'           => strtolower(str_replace(' ','-',$request->news_title)),
            'news_details'              => $request->news_details,
            'tags'                      => $request->tags,

            'breaking_news'             => $request->breaking_news,
            'top_slider'                => $request->top_slider,
            'first_section_three'       => $request->first_section_three,
            'first_section_nine'        => $request->first_section_nine,

            'post_date'                 => date('d-m-Y'),
            'post_month'                => date('F'),
            'image'                     => $save_url,
            'created_at'                => Carbon::now(),

        ]);

        return redirect();
    }

    public function editArticle(Article $article)
    {
        return view();
    }

    public function updateArticle(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required',
            'content' => 'required'
        ]);

        $article->update($request->all());

        return redirect();

    }

    public function deleteArticle(Article $article)
    {
        $article->delete();

        return redirect();
    }
}
