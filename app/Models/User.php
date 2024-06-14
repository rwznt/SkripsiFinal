<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function article() {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isAdmin()
    {
        return $this->level === 'admin';
    }

    public function followees()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'followee_id')
                    ->withTimestamps();
    }

    public function isFollowing(User $user)
    {
        return $this->followees()->where('followee_id', $user->id)->exists();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'followee_id')
                    ->withTimestamps();
    }
}
