<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Person;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\User::factory(10)->create();
//        Person::factory(20)->create();

         \App\Models\User::factory()->create([
             'name' => 'Admin User',
             'email' => 'admin@teste.com',
             'password' => Hash::make('password'),
         ]);
    }
}
