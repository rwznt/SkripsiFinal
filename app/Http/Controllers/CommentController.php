<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
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

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('delete', $comment);

        // Delete the comment and its replies recursively
        $this->deleteCommentAndReplies($comment);

        return back()->with('success', 'Comment deleted successfully.');
    }

    private function deleteCommentAndReplies($comment)
    {
        // Recursively delete replies
        foreach ($comment->replies as $reply) {
            $this->deleteCommentAndReplies($reply);
        }

        // Then delete the comment itself
        $comment->delete();
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        // Find the parent comment
        $parentComment = Comment::findOrFail($id);

        // Create a new comment instance for reply
        $reply = new Comment();
        $reply->content = $request->input('content');
        $reply->user_id = auth()->id();
        $reply->article_id = $parentComment->article_id;
        $reply->parent_id = $parentComment->id;
        $reply->save();

        return redirect()->back()->with('success', 'Reply added successfully.');
    }
}

