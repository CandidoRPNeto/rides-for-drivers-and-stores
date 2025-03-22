<?php

namespace Database\Seeders;

use App\Models\Dealer;
use App\Models\Delivery;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => "Loja Teste",
            'email' => 'store@test.com'
        ]);
        $store = Store::factory()->create([
            'user_id' => $user->id,
            'runs' => 10
        ]);
        Delivery::factory()->count(10)->create(['store_id' => $store->id,]);
        $dealers = Dealer::factory()->count(3)->create();
        $store->dealers()->attach($dealers->pluck('id'));
    }
}
