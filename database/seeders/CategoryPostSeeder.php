<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

use App\Models\Post;

class CategoryPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $categories = Category::all();
        $posts = Post::all();
        foreach ($posts as $post) {
            $post->category()->attach($categories->random());
        }
    }
}
