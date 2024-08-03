<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Chama o seeder de usuários
        // User::factory()->count(10)->create();

        // Cria um usuário específico com dados personalizados
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Chama o seeder de serviços
        $this->call(ServiceSeeder::class);
    }
}
