<?php

namespace App\Interfaces;

use App\Models\BlogPost;

interface BlogPostRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(BlogPost $blogPost, array $data);
    public function delete(BlogPost $blogPost);
}