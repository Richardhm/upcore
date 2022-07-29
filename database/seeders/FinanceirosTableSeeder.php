<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Financeiro;

class FinanceirosTableSeeder extends Seeder
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
                "nome" => "Aguardando Boleto Coletivo"
            ],
            [
                "nome" => "Aguardando Pagamento Adesão Coletivo"
            ],
            [
                "nome" => "Aguardando Pagamento Plano Individual"
            ],
            [
                "nome" => "Aguardando Pagamento Vigencia"
            ],
            [
                "nome" => "Aguardando Pagamento Empresarial"
            ]
        ];
        Financeiro::insert($dados);
    }
}
