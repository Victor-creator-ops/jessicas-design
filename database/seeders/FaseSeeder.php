<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fase; // Importante: Adicione o "use" para o seu Model

class FaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Apaga os dados antigos para garantir que não haja duplicatas
        Fase::query()->delete();
        Fase::create(['nome' => 'Inspiração', 'ordem' => 1]);
        Fase::create(['nome' => 'Estudo Preliminar', 'ordem' => 2]);
        Fase::create(['nome' => 'Execução', 'ordem' => 3]);
        Fase::create(['nome' => 'Renderização', 'ordem' => 4]);
        Fase::create(['nome' => 'Especificações', 'ordem' => 5]);
    }
}