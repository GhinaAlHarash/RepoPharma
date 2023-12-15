<?php

namespace Database\Seeders;

use App\Models\medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('seeders/meds.json');
        $fileContent = file_get_contents($filePath);
        $jsonContent =json_decode($fileContent,true);
        foreach($jsonContent as $med){
            medicine::query()->create($med);
        }
    }
}
