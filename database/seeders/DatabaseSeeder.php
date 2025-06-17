<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Chama o seeder que cria as Fases do Kanban.
        $this->call([
            FaseSeeder::class,
        ]);

        // 2. Cria o usuário administrador "Jessica".
        User::create([
            'name' => 'Jessica Feitosa', // Nome do administrador
            'email' => 'jessica.diretora@email.com', // E-mail de login
            'password' => Hash::make('password'), // Senha padrão é "password"
            'role' => 'admin', // Define o papel como administrador
        ]);

        // Você pode adicionar a criação de outros usuários (designers, clientes) aqui para teste, se desejar.
    }
}
