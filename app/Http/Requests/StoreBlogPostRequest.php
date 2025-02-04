<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'title'      => 'required|max:255',
            'content'    => 'required',
            'slug'       => 'required|unique:blog_posts,slug',
            'blog_image' => 'nullable|image|max:2048',
        ];
    }
}
