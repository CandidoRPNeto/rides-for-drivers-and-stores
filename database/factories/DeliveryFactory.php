<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $destiny = Location::factory()->create();
        $store = Store::factory()->create();
        return [
            'store_id' => $store->id,
            'run_id' => null,
            'rating_id' => null,
            'location_id' => $destiny->id,
            'phone' => fake()->phoneNumber(),
            'name' => fake()->name(),
            'code' => Str::upper(Str::random(6)),
            'status' => collect([1, 4, 5])->random(),
            'position' => 1,
            'finished_at' => null
        ];
    }
}
