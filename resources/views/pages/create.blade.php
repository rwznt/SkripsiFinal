@extends('layout.app')
@section('content')

    <h1>Create New Article</h1>
    <form action="{{ route('route.name') }}" method="POST">
        @csrf
        <div>
        <label for="dropdown">Choose an option:</label>
        <select name="dropdown" id="dropdown">
            <option value="1">Culture</option>
            <option value="2">Technology</option>
            <option value="3">Sports</option>
            <option value="3">Celebritu</option>
            <option value="3">Sports</option>
            <option value="3">Education</option>
            <option value="3">Politics</option>
            <option value="3">Entertainment</option>
        </select>
        </div>
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="body">Body</label>
            <textarea id="body" name="body" required></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>
@endsection
