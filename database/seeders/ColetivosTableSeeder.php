<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coletivo;

class ColetivosTableSeeder extends Seeder
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
                "nome" => "Coletivo Por Adesão"
            ],
            [
                "nome" => "PME Boletado"
            ]
        ];
        Coletivo::insert($dados);
    }
}
