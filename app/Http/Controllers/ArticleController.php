<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Like;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function index()
    {
        $title = 'Latest Articles';
        $articles = Article::latest()->paginate(10);

        return view('pages.latest', compact('title', 'articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', [
           'categories' => $categories,
           'title' => 'Create New Article'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dropdown' => 'required',
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',  // 10 MB
            'content' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('img'), $name_gen);

            $image_path = 'img/' . $name_gen;
        } else {
            return back()->withErrors(['image' => 'Please upload an image file.']);
        }

        $article = new Article();
        $article->category_id = $request->dropdown;
        $article->user_id = auth()->id();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->post_date = now()->format('Y-m-d');
        $article->post_month = now()->format('F');
        $article->image = $image_path;
        $article->save();

        return redirect()->route('articles.show', ['article' => $article->id])->with('success', 'New Article has been created!');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('articles.edit', [
            'article' => $article,
            'categories' => $categories,
            'title' => "Edit Article"
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'content' => 'required'
        ]);

        $article = Article::findOrFail($id);

        $oldImage = $article->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('img'), $name_gen);

            if ($oldImage && !Str::contains($oldImage, 'placeholder-image.png') && Storage::exists($oldImage)) {
                Storage::delete($oldImage);
            }

            $article->image = 'img/' . $name_gen;
        }

        $article->category_id = $request->category_id;
        $article->title = $request->title;
        $article->content = $request->content;
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article Successfully Updated');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if (Storage::exists($article->image)) {
            Storage::delete($article->image);
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article Successfully Deleted');
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

        $articles = $category->articles()->paginate(10);

        return view('articles.by_category', compact('category', 'articles', 'title'));
    }

    public function like($id)
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

    public function unlike($id)
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

}

