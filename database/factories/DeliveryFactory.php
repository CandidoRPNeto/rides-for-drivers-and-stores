<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'run_id' => null,
            'rating_id' => null,
            'destiny_id' => $destiny->id,
            'code' => 'AWZ123',
            'position' => 1,
            'finished_at' => null
        ];
    }
}
