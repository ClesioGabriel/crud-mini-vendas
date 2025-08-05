<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->clesio()->create();

        User::factory()->count(5)->create();

        $this->call([
            CustomerSeeder::class,
            ProductSeeder::class,
            SaleSeeder::class,
        ]);
    }
}
