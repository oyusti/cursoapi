<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory(100)->create()->each(function ($post) {
            Image::factory(4)->create([
                'imageable_id' => $post->id,
                'imageable_type' => Post::class,
            ]);
            $post->tags()->attach([
                random_int(1, 5),
                random_int(6, 10)
            ]);
        });
    }
}
