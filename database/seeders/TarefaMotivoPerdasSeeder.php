<?php

namespace Database\Seeders;

use App\Models\TarefaMotivoPerda;
use Illuminate\Database\Seeder;

class TarefaMotivoPerdasSeeder extends Seeder
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
                "nome" => "preco",
                "descricao" => "Preço"
            ],
            [
                "nome" => "ja_tem_plano",
                "descricao" => "Já Tem Plano"
            ],
            [
                "nome" => "fez_unimed",
                "descricao" => "Fez Unimed"
            ],
            [
                "nome" => "sem_interesse",
                "descricao" => "Sem Interesse"
            ]
           
        ];    



        TarefaMotivoPerda::insert($dados);
    }
}
