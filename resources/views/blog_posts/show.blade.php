@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $blogPost->title }}</h1>
    <p>
        <small>
            By {{ $blogPost->user->name }} | {{ $blogPost->created_at->format('Y-m-d') }}
        </small>
    </p>
    @if($blogPost->blog_image)
    <div class="mb-3">
        <img src="{{ asset('storage/' . $blogPost->blog_image) }}" alt="Blog Image" class="img-fluid" style="max-width:400px;">
    </div>
    @endif
    <div class="mb-4">
        {{-- for raw input --}}
        {!! nl2br(e($blogPost->content)) !!}
    </div>
    <div>
        <a href="{{ route('blog-posts.edit', $blogPost->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('blog-posts.destroy', $blogPost->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete this post?')">
                Delete
            </button>
        </form>
        <a href="{{ route('blog-posts.index') }}" class="btn btn-secondary">Back to Posts</a>
    </div>
</div>
@endsection
