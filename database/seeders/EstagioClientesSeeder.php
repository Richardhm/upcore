<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstagioClientes;

class EstagioClientesSeeder extends Seeder
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
                "nome" => "Interessado Frio",
            ],
            [
                "nome" => "Interessado Morno",
            ],
            [
                "nome" => "Interessado Frio",
            ],
            [
                "nome" => "Aguardando Documentação",
            ],
            [
                "nome" => "Interesse Futuro",
            ],
            [
                "nome" => "Sem Interesse",
            ],
           
           
        ];
        EstagioClientes::insert($dados);
    }
}
