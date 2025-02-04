<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Services\BlogPostService;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    protected BlogPostService $blogPostService;
    
    public function __construct(BlogPostService $blogPostService)
    {
        $this->blogPostService = $blogPostService;
    }
    
    public function index()
    {
        $posts = $this->blogPostService->getAllPosts();
        return view('blog_posts.index', compact('posts'));
    }
    
    public function create()
    {
        return view('blog_posts.create');
    }
    
    public function store(StoreBlogPostRequest $request)
    {
        $data = $request->only(['title', 'content', 'slug']);
        
        // Handle image upload if provided.
        if ($request->hasFile('blog_image')) {
            $data['blog_image'] = $request->file('blog_image')->store('blog_images', 'public');
        }
        
        $this->blogPostService->createPost($data);
        
        return redirect()->route('blog-posts.index')
                         ->with('success', 'Blog post created successfully.');
    }
    
    public function edit(BlogPost $blogPost)
    {
        // Allow editing only if admin or if the current user is the owner.
        if (Auth::user()->hasRole('admin') || $blogPost->user_id == Auth::id()) {
            return view('blog_posts.edit', compact('blogPost'));
        }
        abort(403);
    }
    
    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost)
    {
        $data = $request->only(['title', 'content', 'slug']);
        if ($request->hasFile('blog_image')) {
            $data['blog_image'] = $request->file('blog_image')->store('blog_images', 'public');
        }
        $this->blogPostService->updatePost($blogPost, $data);
        
        return redirect()->route('blog-posts.index')
                         ->with('success', 'Blog post updated successfully.');
    }

    public function show(BlogPost $blogPost)
    {
        $this->blogPostService->showPost($blogPost);
        return view('blog_posts.show', compact('blogPost'));
    }
    
    public function destroy(BlogPost $blogPost)
    {
        $this->blogPostService->deletePost($blogPost);
        return redirect()->route('blog-posts.index')
                         ->with('success', 'Blog post deleted successfully.');
    }
}
