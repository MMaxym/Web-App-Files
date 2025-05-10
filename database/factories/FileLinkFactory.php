<?php

namespace Database\Factories;

use App\Enums\FileLinkType;
use App\Models\File;
use App\Models\FileLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileLinkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'file_id' => File::query()->inRandomOrder()->first()?->id,
            'type' => $this->faker->randomElement(FileLinkType::cases()),
            'token' => FileLink::generateToken(),
            'is_active' => $this->faker->boolean(70),
            'views_count' => $this->faker->numberBetween(0, 50),
        ];
    }
}
