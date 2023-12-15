<?php

namespace Database\Seeders;

use App\Models\classification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('seeders/classifications.json');
        $fileContent = file_get_contents($filePath);
        $jsonContent =json_decode($fileContent,true);
        foreach($jsonContent as $class){
            classification::query()->create($class);
        }

    }
}
