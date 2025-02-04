<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" id="title" 
           value="{{ old('title', isset($blogPost) ? $blogPost->title : '') }}" 
           class="form-control" required>
</div>

<div class="mb-3">
    <label for="slug" class="form-label">Slug</label>
    <input type="text" name="slug" id="slug" 
           value="{{ old('slug', isset($blogPost) ? $blogPost->slug : '') }}" 
           class="form-control" required>
</div>

<div class="mb-3">
    <label for="content" class="form-label">Content</label>
    <textarea name="content" id="content" rows="5" class="form-control" required>{{ old('content', isset($blogPost) ? $blogPost->content : '') }}</textarea>
</div>

<div class="mb-3">
    <label for="blog_image" class="form-label">Blog Image</label>
    <input type="file" name="blog_image" id="blog_image" class="form-control">
    @if(isset($blogPost) && $blogPost->blog_image)
       <div class="mt-2">
           <img src="{{ asset('storage/' . $blogPost->blog_image) }}" alt="Current Image" style="max-width: 200px;">
       </div>
    @endif
</div>
