<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'content',
        'parent_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function isReply()
    {
        return $this->parent_id !== null;
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function findUltimateParent($parent_id)
    {
        $comment = $this->find($parent_id);
        if ($comment->parent_id) {
            return $this->findUltimateParent($comment->parent_id);
        }
        return $comment;
    }
}
