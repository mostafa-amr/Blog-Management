@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Blog Post</h1>
    
    <form action="{{ route('blog-posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @include('blog_posts.partials._form')
        
        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>
@endsection
