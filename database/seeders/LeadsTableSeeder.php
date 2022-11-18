<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leads;

class LeadsTableSeeder extends Seeder
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
                "nome" => "Plantão de Vendas"
            ],
            [
                "nome" => "Prospecção"
            ],
            [
                "nome" => "Atendimento Iniciado"
            ],
            [
                "nome" => "Sem Contato"
            ]
        ];
        Leads::insert($dados);
    }
}
