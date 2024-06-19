@if ($user->image)
    <img src="{{ asset('storage/profile_image/' . $user->image) }}" class="profile-picture" alt="{{ $user->name }}">
@else
    <img src="{{ asset('images/default-picture.jpg') }}" class="profile-picture" alt="{{ $user->name }}">
@endif
<h1 class="text-center mt-3">{{ $user->name }}</h1>

<div class="d-flex justify-content-center mt-3">
    <div class="profile-stats">
        <span><strong>{{ $followerCount }}</strong> Followers</span>
        <span><strong>{{ $followingCount }}</strong> Following</span>
    </div>
</div>

@auth
    @unless($isOwnProfile)
        <div class="follow-button text-center mt-3">
            @if (\App\Models\Follow::isFollowing(auth()->user(), $user))
                <form action="{{ route('user.unfollow', ['userId' => $user->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Unfollow</button>
                </form>
            @else
                <form action="{{ route('user.follow', ['userId' => $user->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Follow</button>
                </form>
            @endif
        </div>
    @endunless
@endauth
