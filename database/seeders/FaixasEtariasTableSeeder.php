<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaixaEtaria;

class FaixasEtariasTableSeeder extends Seeder
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
                "nome" => "0 a 18"
            ],
            [
                "nome" => "19 a 23"
            ],
            [
                "nome" => "24 a 28"
            ],
            [
                "nome" => "29 a 33"
            ],
            [
                "nome" => "34 a 38"
            ],
            [
                "nome" => "39 a 43"
            ],
            [
                "nome" => "44 a 48"
            ],
            [
                "nome" => "49 a 53"
            ],
            [
                "nome" => "54 a 58"
            ],
            [
                "nome" => "59+"
            ]
        ];
        FaixaEtaria::insert($dados);
    }
}
