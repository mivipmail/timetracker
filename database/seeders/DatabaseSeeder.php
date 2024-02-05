<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Тест Тестов',
            'login' => 'test',
            'password' => bcrypt('111'),
        ]);

        $this->call([ProjectSeeder::class, TaskSeeder::class]);
    }
}
