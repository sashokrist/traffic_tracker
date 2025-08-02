<?php

namespace Database\Factories;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition(): array
    {
        return [
            'ip_address' => $this->faker->ipv4,
            'page_url' => $this->faker->url,
            'visited_at' => now(),
            'country' => $this->faker->country,
            'region' => $this->faker->state,
            'city' => $this->faker->city,
            'isp' => $this->faker->company,
        ];
    }
}
