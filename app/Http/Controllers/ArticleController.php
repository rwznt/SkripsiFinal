<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Comment;
use App\Models\Like;

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
            'dropdown' => 'required',
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
        ]);

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('upload/news/'), $name_gen);
        $save_url = 'upload/news/' . $name_gen;

        $article = new Article();
        $article->category_id = $request->dropdown;
        $article->user_id = auth()->id(); // Assuming user_id is the currently logged-in user
        $article->title = $request->title;
        $article->content = $request->content;
        $article->post_date = now()->format('Y-m-d');
        $article->post_month = now()->format('F');
        $article->image = $save_url;
        $article->save();

        $notification = [
            'message' => 'Article Successfully Inserted',
            'alert_type' => 'success'
        ];

        return redirect()->route('articles.show', ['article' => $article->id])->with($notification);
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

        return view('pages.review_list', compact('articles'), [
            'title' => 'Review List'
        ]);
    }

    public function updateReview(Request $request, $id)
    {
        $request->validate([
            'trustFactor' => 'required|integer|min:1|max:100',
            'adminComment' => 'nullable|string|max:255',
        ]);


        $article = Article::findOrFail($id);
        $article->trustfactor = $request->trustFactor;
        $article->admin_comment = $request->adminComment;
        $article->reviewed = true;
        $article->save();

        return redirect()->back()->with('success', 'Review updated successfully!');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        $title  = $article->title;
        return view('articles.show', compact('article', 'title'));
    }

    public function articlesByCategory(Category $category)
    {
        $articles = Article::where('category_id', $category->id)
                           ->latest()
                           ->get();

                           $title = "Articles in Category: " . $category->name;

                           return view('articles.by_category', compact('category', 'articles', 'title'));
    }

    public function like(Request $request, $id)
{
    $article = Article::findOrFail($id);
    $userId = auth()->id();


    if (!$article->likes()->where('user_id', $userId)->exists()) {
        $like = new Like();
        $like->article_id = $article->id;
        $like->user_id = $userId;
        $like->save();

        $article->increment('likes_count');

        return redirect()->back()->with('success', 'Article liked successfully!');
    } else {
        return redirect()->back()->with('error', 'You have already liked this article!');
    }
}

public function unlike(Request $request, $id)
{
    $article = Article::findOrFail($id);
    $userId = auth()->id();

    $like = $article->likes()->where('user_id', $userId)->first();

    if ($like) {

        $like->delete();
        $article->decrement('likes_count');

        return redirect()->back()->with('success', 'Article unliked successfully!');
    } else {
        return redirect()->back()->with('error', 'You have not liked this article!');
    }
}

    public function comment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $article = Article::findOrFail($id);
        $comment = new Comment();
        $comment->article_id = $article->id;
        $comment->user_id = auth()->id();
        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->back()->with('success', 'Comment added!');
    }
}

