@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Blog Post</h1>
    
    <form action="{{ route('blog-posts.update', $blogPost->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        @include('blog_posts.partials._form', ['blogPost' => $blogPost])
        
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</div>
@endsection
