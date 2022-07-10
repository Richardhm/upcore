<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Planos;

class PlanosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            [
                "nome" => "Individual"
            ],
            [
                "nome" => "Super Simples"
            ],
            [
                "nome" => "Coletivo Por Adesão"
            ],
            [
                "nome" => "PME Boletado"
            ],
           
        ];
        Planos::insert($dados);
    }
}
