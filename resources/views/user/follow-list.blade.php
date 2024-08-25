@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Follow List</h2>
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="keyword" value="{{ $keyword }}" placeholder="Search for users">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <ul class="nav nav-tabs" id="followTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" aria-controls="followers" aria-selected="true">Followers ({{ $followerCount }})</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="following-tab" data-bs-toggle="tab" data-bs-target="#following" type="button" role="tab" aria-controls="following" aria-selected="false">Following ({{ $followingCount }})</button>
                    </li>
                </ul>

                <div class="tab-content" id="followTabsContent">
                    <div class="tab-pane fade show active" id="followers" role="tabpanel" aria-labelledby="followers-tab">
                        @if ($followers->isEmpty())
                            <p class="text-muted">No followers found {{ $keyword? "matching \"$keyword\"" : "" }}.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($followers as $follower)
                                    <li class="list-group-item d-flex align-items-center">
                                        <div class="me-3">
                                            <img src="@if($follower->image) {{ asset('storage/profile_image/'. $follower->image) }} @else {{ asset('images/default-picture.jpg') }} @endif" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $follower->name }}">
                                        </div>
                                        <div>
                                            <h5><a href="{{ route('user.detail', ['id' => $follower->id]) }}" class="text-decoration-none text-dark">{{ $follower->name }}</a></h5>
                                            <p>{{ $follower->email }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="following" role="tabpanel" aria-labelledby="following-tab">
                        @if ($following->isEmpty())
                            <p class="text-muted">No following found {{ $keyword? "matching \"$keyword\"" : "" }}.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($following as $follow)
                                    <li class="list-group-item d-flex align-items-center">
                                        <div class="me-3">
                                            <img src="@if($follow->image) {{ asset('storage/profile_image/'. $follow->image) }} @else {{ asset('images/default-picture.jpg') }} @endif" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $follow->name }}">
                                        </div>
                                        <div>
                                            <h5><a href="{{ route('user.detail', ['id' => $follow->id]) }}" class="text-decoration-none text-dark">{{ $follow->name }}</a></h5>
                                            <p>{{ $follow->email }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection