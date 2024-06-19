<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Bas Test',
            'email' => 'bas@mail.com',
            'password' => 'password',
        ]);

        User::factory()
            ->count(2)
            ->has(
                Post::factory()
                    ->count(2)
                    ->has(
                        Comment::factory()
                            ->count(3)
                            ->state(function (array $attributes, Post $post) {
                                return [
                                    'user_id' => User::inRandomOrder()->first()->id,
                                    'post_id' => $post->id,
                                ];
                            }),
                        'comments'
                    ),
                'posts'
            )
            ->create();
    }
}
