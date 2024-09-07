<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->article_id = $validatedData['article_id'];
        $comment->user_id = auth()->id();
        $comment->content = $validatedData['content'];
        $comment->save();

        $article = Article::find($comment->article_id);
        $authenticatedUser = auth()->user();

        $notification = new Notification();
        $notification->user_id = $comment->user_id;
        $notification->from_user_id = $authenticatedUser->id;
        $notification->type = 'review';
        $notification->at_article_id = $comment->article_id;
        $notification->message = "Your Article has been commented by " . $authenticatedUser->name . " at " . $article->title;
        $notification->save();


        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('delete', $comment);

        $this->deleteCommentAndReplies($comment);

        return back()->with('success', 'Comment deleted successfully.');
    }

    private function deleteCommentAndReplies($comment)
    {
        foreach ($comment->replies as $reply) {
            $this->deleteCommentAndReplies($reply);
        }

        $comment->delete();
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $parentComment = Comment::findOrFail($id);

        $reply = new Comment();
        $reply->content = $request->input('content');
        $reply->user_id = auth()->id();
        $reply->article_id = $parentComment->article_id;
        $reply->parent_id = $parentComment->id;
        $reply->save();

        $article = Article::find($parentComment->article_id);
        $authenticatedUser = auth()->user();
        $notification = new Notification();
        $notification->user_id = $parentComment->user_id;
        $notification->from_user_id = $authenticatedUser->id;
        $notification->type = 'review';
        $notification->at_article_id = $parentComment->article_id;
        $notification->message = "Your comment has been replied by " . $authenticatedUser->name . " at " . $article->title;
        $notification->save();

        return redirect()->back()->with('success', 'Reply added successfully.');
    }
}

