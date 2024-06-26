<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Article;

class ArticlePolicy
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

    public function viewAny(User $user)
    {
        // Logic to determine if the user can view any articles
        return true; // Example: Allow everyone to view any articles
    }

    public function view(User $user, Article $article)
    {
        // Logic to determine if the user can view the article
        return true; // Example: Allow everyone to view the article
    }

    public function create(User $user)
    {
        // Logic to determine if the user can create articles
        return true; // Example: Allow everyone to create articles
    }

    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    public function edit(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article)
    {
        return $user->isAdmin() || $user->id === $article->user_id;
    }

    public function review(User $user)
    {
        return $user->isAdmin();
    }
}
