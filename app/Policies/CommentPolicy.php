<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function delete(User $user, Comment $comment)
    {
        // Only the comment owner, the article owner, or admins can delete comments
        return $user->id === $comment->user_id ||
               $user->id === $comment->article->user_id ||
               $user->isAdmin();
    }
}
