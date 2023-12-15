<?php

namespace Database\Seeders;

use App\Models\order_Medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Orders_medsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('seeders/orders_meds.json');
        $fileContent = file_get_contents($filePath);
        $jsonContent =json_decode($fileContent,true);
        foreach($jsonContent as $order_med){
            order_Medicine::query()->create($order_med);
        }
    }
}
