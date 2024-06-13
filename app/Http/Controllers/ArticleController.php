<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Intervention\Image\Facades\Image;


class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('pages.articlesresult');
    }

    public function create()
    {
        $categories = Category::all();

        return view('pages.create', [
            'categories' => $categories,
            'title' => 'Create Article'
        ]);
    }

    public function store(Request $request)
    {
        $image      = $request->file('image');

        $name_gen   = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(784,436)->save('upload/news/'.$name_gen);

        $save_url = 'upload/news/'.$name_gen;

        Article::insert([

            'category_id'               => $request->category_id,
            'user_id'                   => $request->user_id,
            'title'                     => $request->title,
            'title_slug'                => strtolower(str_replace(' ','-',$request->news_title)),
            'content'                   => $request->content,
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

        $notification = array(
            'message' => 'Article Successfully Inserted',
            'alert_type' => 'success'
        );

        return redirect()->route('create')->with($notification);
    }

    public function editArticle($id)
    {
        $articles = Article::findOrFail($id);
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

        $notification = array(
            'message' => 'Article Successfully Updated',
            'alert_type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    public function deleteArticle($id)
    {
        $articles = Article::findOrFail($id);
        $articles->delete();

        $notification = array(
            'message' => 'Article Successfully Deleted',
            'alert_type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function review() {
        return view();
    }

    public function reviewUp(Request $request, Article $article)
    {
        $articles = Article::findOrFail($article);
        Article::insert([
            'trustfactor' => $request->trustFactor
        ]);

    }

    public function newlyCreated()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();

        return view('articles.newly-created', compact('articles'));
    }
}
