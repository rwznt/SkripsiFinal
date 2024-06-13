@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Search Accounts</h1>
        <form action="{{ route('accounts.search') }}" method="GET">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" value="{{ request('email') }}">
            </div>
            <div class="form-group">
                <label for="date_from">Date From</label>
                <input type="date" name="date_from" id="date_from" class="form-control"
                    value="{{ request('date_from') }}">
            </div>
            <div class="form-group">
                <label for="date_to">Date To</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <h2 class="mt-5">Search Results</h2>
        @if ($users->isNotEmpty())
            @foreach ($users as $user)
                <div class="card mb-3">
                    <div class="card-body">
                        <h2>{{ $user->name }}</h2>
                        <p>{{ $user->email }}</p>
                        <p>Joined: {{ $user->created_at->format('M d, Y') }}</p>
                        <a href="{{ route('profile.show', $user) }}" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            @endforeach

            {{ $users->links() }}
        @else
            <p>No Account Found.</p>
        @endif
    </div>
@endsection
