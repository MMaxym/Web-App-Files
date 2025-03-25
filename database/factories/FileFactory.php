<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()?->id,
            'file_name' => $this->faker->word() . '.pdf',
            'file_path' => 'uploads/' . Str::random(10) . '.pdf',
            'comment' => $this->faker->optional(0.3)->sentence(),
            'expiration_date' => $this->faker->optional()->dateTimeBetween('+1 week', '+1 month'),
            'views_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}
