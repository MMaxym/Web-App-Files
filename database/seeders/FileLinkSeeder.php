<?php

namespace Database\Seeders;

use App\Models\FileLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileLinkSeeder extends Seeder
{
    public function run(): void
    {
        FileLink::factory(50)->create();
    }
}
