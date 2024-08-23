<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'follower_id',
        'following_id',
    ];

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    public static function follow(User $user)
    {
        $authenticatedUser = Auth::user();

        if (!$authenticatedUser || $authenticatedUser->id === $user->id) {
            return false;
        }

        if (self::isFollowing($authenticatedUser, $user)) {
            return false;
        }

        $follow = new self();
        $follow->follower_id = $authenticatedUser->id;
        $follow->following_id = $user->id;
        $follow->save();

        return true;
    }

    public static function unfollow(User $user)
    {
        $authenticatedUser = Auth::user();

        if (!$authenticatedUser) {
            return false;
        }

        $follow = self::where('follower_id', $authenticatedUser->id)
                      ->where('following_id', $user->id)
                      ->first();

        if ($follow) {
            $follow->delete();
            return true;
        }

        return false;
    }

    public static function isFollowing(User $follower, User $following)
    {
        return self::where('follower_id', $follower->id)
                   ->where('following_id', $following->id)
                   ->exists();
    }

    public static function followerCount(User $user)
    {
        return self::where('following_id', $user->id)->count();
    }

    public static function followingCount(User $user)
    {
        return self::where('follower_id', $user->id)->count();
    }

    public static function canFollow(User $authenticatedUser, User $user)
    {
        return !$authenticatedUser->is($user) && !self::isFollowing($authenticatedUser, $user);
    }
}
