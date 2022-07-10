<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Etiquetas;

class EtiquetasTableSeeder extends Seeder
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
                "nome" => "Atendimento em Aberto",
                "cor" => "#1d0ef1"
            ],
            [
                "nome" => "Interessado",
                "cor" => "#289d20"
            ],
            [
                "nome" => "Aguardando Pagamento",
                "cor" => "#e5f505"
            ],
            [
                "nome" => "Sem Interesse",
                "cor" => "#f70808"
            ],
           
        ];
        Etiquetas::insert($dados);
    }
}
