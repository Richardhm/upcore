<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Acomodacao;

class AcomodacaoTableSeeder extends Seeder
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
                "nome" => "Apartamento"
            ],
            [
                "nome" => "Enfermaria"
            ],
            [
                "nome" => "Ambulatorial"
            ]
        ];
        Acomodacao::insert($dados);
    }
}
