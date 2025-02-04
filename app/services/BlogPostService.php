<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Interfaces\BlogPostRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogPostService
{
    protected BlogPostRepositoryInterface $blogPostRepository;
    
    public function __construct(BlogPostRepositoryInterface $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }
    
    
    public function getAllPosts()
    {
        if (Auth::user()->hasRole('admin')) {
            return $this->blogPostRepository->all();
        } else {
            return $this->blogPostRepository->all()->where('user_id', Auth::id());
        }
    }
    
    
    public function createPost(array $data)
    {
        $data['user_id'] = Auth::id();
        return $this->blogPostRepository->create($data);
    }
    
    public function updatePost(BlogPost $blogPost, array $data)
    {
        if (Auth::user()->hasRole('admin') || $blogPost->user_id == Auth::id()) {
            return $this->blogPostRepository->update($blogPost, $data);
        }
        abort(403, 'Unauthorized action.');
    }
    
    public function deletePost(BlogPost $blogPost)
    {
        if (Auth::user()->hasRole('admin') || $blogPost->user_id == Auth::id()) {
            $result = DB::transaction(function () use ($blogPost) {
                return $this->blogPostRepository->delete($blogPost);
            });
            if ($result && $blogPost->blog_image && Storage::disk('public')->exists($blogPost->blog_image)) {
                Storage::disk('public')->delete($blogPost->blog_image);
            }
            
            return $result;
        }
        abort(403, 'Unauthorized action.');
    }

    public function showPost(BlogPost $blogPost)
    {
        if (Auth::user()->hasRole('admin') || $blogPost->user_id == Auth::id()) {
            return $this->blogPostRepository->find($blogPost->id);
        }
        abort(403, 'Unauthorized action.');
    }
}
