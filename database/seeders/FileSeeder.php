<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\File as HttpFile;

class FileSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        for ($i = 0; $i < 5; $i++) {
            $user = $users->random();
            $fileName = 'test_'. Str::random(10) . '.pdf';
            $uniqueFilePath = 'uploads/' . uniqid() . "_" . $fileName;

            $fileContent = 'This is a fake file for testing purposes.';
            $filePath = storage_path('app/private/' . $uniqueFilePath);
            file_put_contents($filePath, $fileContent);

            Storage::putFileAs('/', new HttpFile($filePath), $uniqueFilePath);

            File::factory()->create([
                'user_id' => $user->id,
                'file_name' => $fileName,
                'file_path' => $uniqueFilePath,
                'comment' => 'Sample file ' . ($i + 1),
                'views_count' => rand(0, 100),
                'expiration_date' => now()->addDays(rand(10, 50)),
            ]);
        }
    }
}
