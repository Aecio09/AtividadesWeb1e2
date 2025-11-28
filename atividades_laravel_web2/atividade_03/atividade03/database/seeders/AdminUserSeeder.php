<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
        
        // Criar bibliotecario de teste
        User::updateOrCreate(
            ['email' => 'bibliotecario@example.com'],
            [
                'name' => 'Bibliotecario',
                'password' => Hash::make('password'),
                'role' => 'bibliotecario',
            ]
        );
        
        // Criar cliente de teste
        User::updateOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'name' => 'Cliente',
                'password' => Hash::make('password'),
                'role' => 'cliente',
            ]
        );
    }
}
