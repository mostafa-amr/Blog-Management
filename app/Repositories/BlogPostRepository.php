<?php

namespace App\Repositories;

use App\Interfaces\BlogPostRepositoryInterface;
use App\Models\BlogPost;

class BlogPostRepository implements BlogPostRepositoryInterface
{
    public function all()
    {
        return BlogPost::with('user')->get();
    }
    
    public function find(int $id)
    {
        return BlogPost::with('user')->find($id);
    }
    
    public function create(array $data)
    {
        return BlogPost::create($data);
    }
    
    public function update(BlogPost $blogPost, array $data)
    {
        return $blogPost->update($data);
    }
    
    public function delete(BlogPost $blogPost)
    {
        return $blogPost->delete();
    }
}
