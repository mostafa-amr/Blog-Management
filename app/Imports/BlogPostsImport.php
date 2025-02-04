<?php

namespace App\Imports;

use App\Models\BlogPost;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class BlogPostsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public $successes = [];

    public function model(array $row)
    {
        $this->successes[] = $row;
        return new BlogPost([
            'title'      => $row['title'],
            'content'    => $row['content'],
            'slug'       => $row['slug'],
            'blog_image' => $row['blog_image'] ?? null,
            'user_id'    => $row['author_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            'title'      => 'required|max:255',
            'content'    => 'required',
            'slug'       => 'required|unique:blog_posts,slug',
            'blog_image' => 'nullable|image|max:2048',
            'author_id'  => 'required|exists:users,id',
        ];
    }

    public function getFailureReasons(): array
    {
        $failureArray = [];

        foreach ($this->failures as $failure) {
            $failureArray[] = [
                'row'       => $failure->row(),       
                'attribute' => $failure->attribute(),  
                'errors'    => $failure->errors(),     
                'values'    => $failure->values(),     
            ];
        }

        return $failureArray;
    }
}

