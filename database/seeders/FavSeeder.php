<?php

namespace Database\Seeders;

use App\Models\favorite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('seeders/fav.json');
        $fileContent = file_get_contents($filePath);
        $jsonContent =json_decode($fileContent,true);
        foreach($jsonContent as $fav){
            favorite::query()->create($fav);
        }
    }
}
