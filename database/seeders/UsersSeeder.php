<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('seeders/users.json');
        $fileContent = file_get_contents($filePath);
        $jsonContent =json_decode($fileContent,true);
        foreach($jsonContent as $user){
            User::query()->create($user);
        }
    }
}
