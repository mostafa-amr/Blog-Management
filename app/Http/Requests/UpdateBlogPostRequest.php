<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $blogPostId = $this->route('blog_post')->id;
        
        return [
            'title'      => 'required|max:255',
            'content'    => 'required',
            'slug'       => 'required|unique:blog_posts,slug,' . $blogPostId,
            'blog_image' => 'nullable|image|max:2048',
        ];
    }
}
