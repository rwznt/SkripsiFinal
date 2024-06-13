<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    public function index()
    {
        $title = 'Latest Articles';
        $articles = Article::latest()->get();

        return view('articles.latest', compact('title', 'articles'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('articles.create', [
            'categories' => $categories,
            'title' => 'Create Article'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'user_id' => 'required',
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
            'tags' => 'nullable',
            'breaking_news' => 'boolean',
            'top_slider' => 'boolean',
            'first_section_three' => 'boolean',
            'first_section_nine' => 'boolean',
        ]);

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(784, 436)->save('upload/news/' . $name_gen);
        $save_url = 'upload/news/' . $name_gen;

        Article::create([
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'title_slug' => strtolower(str_replace(' ', '-', $request->title)),
            'content' => $request->content,
            'tags' => $request->tags,
            'breaking_news' => $request->has('breaking_news'),
            'top_slider' => $request->has('top_slider'),
            'first_section_three' => $request->has('first_section_three'),
            'first_section_nine' => $request->has('first_section_nine'),
            'post_date' => Carbon::now()->format('d-m-Y'),
            'post_month' => Carbon::now()->format('F'),
            'image' => $save_url,
        ]);

        $notification = [
            'message' => 'Article Successfully Inserted',
            'alert_type' => 'success'
        ];

        return redirect()->route('create')->with($notification);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required'
        ]);

        $article = Article::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(784, 436)->save('upload/news/' . $name_gen);
            $save_url = 'upload/news/' . $name_gen;

            if (Storage::exists($article->image)) {
                Storage::delete($article->image);
            }

            $article->image = $save_url;
        }

        $article->category_id = $request->category_id;
        $article->title = $request->title;
        $article->title_slug = strtolower(str_replace(' ', '-', $request->title));
        $article->content = $request->content;
        $article->tags = $request->tags;
        $article->breaking_news = $request->has('breaking_news');
        $article->top_slider = $request->has('top_slider');
        $article->first_section_three = $request->has('first_section_three');
        $article->first_section_nine = $request->has('first_section_nine');
        $article->save();

        $notification = [
            'message' => 'Article Successfully Updated',
            'alert_type' => 'success'
        ];

        return redirect()->route('articles.index')->with($notification);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if (Storage::exists($article->image)) {
            Storage::delete($article->image);
        }

        $article->delete();

        $notification = [
            'message' => 'Article Successfully Deleted',
            'alert_type' => 'success'
        ];

        return redirect()->route('articles.index')->with($notification);
    }

    public function review()
    {
        $articles = Article::where('reviewed', false)->latest()->get();
        return view('articles.review', compact('articles'));
    }

    public function updateTrustFactor(Request $request, $id)
    {
        $request->validate([
            'trustFactor' => 'required|numeric|min:1|max:100',
            'comment' => 'nullable|string|max:255',
        ]);

        $article = Article::findOrFail($id);
        $article->trustfactor = $request->trustFactor;
        $article->admin_comment = $request->comment;
        $article->reviewed = true;
        $article->save();

        $notification = [
            'message' => 'Trust Factor Updated Successfully',
            'alert_type' => 'success'
        ];

        return redirect()->route('articles.review')->with($notification);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }

    public function articlesByCategory(Category $category)
    {
        $articles = Article::where('category_id', $category->id)
                           ->latest()
                           ->get();

                           $title = "Articles in Category: " . $category->name;

                           return view('articles.by_category', compact('category', 'articles', 'title'));
    }
}

