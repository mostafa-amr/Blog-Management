<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'user_id'   => User::factory(),
            'title'     => $title,
            'content'   => $this->faker->paragraph(5),
            'slug'      => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(100, 999),
            'blog_image'=> null,
        ];
    }
}
