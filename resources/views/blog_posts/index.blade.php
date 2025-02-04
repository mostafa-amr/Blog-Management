@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Blog Posts</h1>
    <a href="{{ route('blog-posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>
    <a href="{{ route('excel.export') }}" class="btn btn-success mb-3">Export Blog Posts</a>
    @can('import_blog_posts')
    <a href="{{ route('excel.import.form') }}" class="btn btn-info mb-3">Import Blog Posts</a>
    @endcan
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($posts->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Author</th>
                    <th style="width: 200px;">Created At</th>
                    <th style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('blog-posts.show', $post->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('blog-posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>       
                        <form action="{{ route('blog-posts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No blog posts found.</p>
    @endif
</div>
@endsection
