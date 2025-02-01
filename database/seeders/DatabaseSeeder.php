<?php

namespace Database\Seeders;

use Domain\Blog\Models\Article;
use Domain\User\Models\Author;
use Domain\User\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $authors = Author::factory()->count(5)->create();

        foreach ($authors as $author) {
            Article::factory()
                ->count(random_int(0, 4))
                ->for($author)
                ->create();
        }

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
