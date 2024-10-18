<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $tags = Tag::all();
        $users = User::all();

        Post::factory(20)
            ->sequence(fn () => [
                'category_id' => $categories->random(),
            ])
            ->hasComments(5, fn() => ['user_id' => $users->random()])
            ->create()
            ->each(fn ($post) => $post->tags()->attach($tags->random(rand(0, 3))));
    }
}
