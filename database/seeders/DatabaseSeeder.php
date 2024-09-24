<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Operator;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Operator::create([
            'username' => 'op1',
            'password' => Hash::make('1234'),
        ]);
    }
}
