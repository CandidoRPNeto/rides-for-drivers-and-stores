<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Rating;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $score = rand(0, 4);
        $descriptions = [
            'Incomivel',
            'Chegou frio',
            'Exatamente oque eu esperava',
            'Muito bom',
            'Excelente',
        ];
        return [
            'score' => $score + 1,
            'description' => $descriptions[$score]
        ];
    }
}
