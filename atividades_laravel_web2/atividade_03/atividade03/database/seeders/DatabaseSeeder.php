<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        FakerFactory::create()->unique(true);
            $this->call([
                CategorySeeder::class,
                AuthorPublisherBookSeeder::class,
                UserBorrowingSeeder::class,
                \Database\Seeders\AdminUserSeeder::class,
            ]);
    //         $this->call([
    //     CategorySeeder::class,
    //     AuthorPublisherBookSeeder::class,
    //     UserBorrowingSeeder::class,
    // ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
