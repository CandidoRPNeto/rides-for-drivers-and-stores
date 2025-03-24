<?php

namespace Database\Seeders;

use App\Models\Dealer;
use App\Models\Store;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (App::environment('local')) {
            $this->call(StoreExampleSeeder::class);
            Dealer::factory()->count(3)->create();
        }
    }
}
