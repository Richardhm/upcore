<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $dados = [
        //     [
        //         "name" => "configurações"
        //     ],
        //     [
        //         "name" => "configurações_corretora"
        //     ],
        //     [
        //         "name" => "configurações_corretor"
        //     ],
        //     [
        //         "name" => "configurações_operadora"
        //     ],
        //     [
        //         "name" => "configurações_administradora"
        //     ],
        //     [
        //         "name" => "configurações_cidades"
        //     ],
            
        //     [
        //         "name" => "configurações_planos"
        //     ],
        //     [
        //         "name" => "configurações_tabela_de_preços"
        //     ],
        //     [
        //         "name" => "configurações_etiquetas"
        //     ],
        //     [
        //         "name" => "orçamento"
        //     ],
        //     [
        //         "name" => "contratos"
        //     ],
        //     [
        //         "name" => "clientes"
        //     ],
        //     [
        //         "name" => "clientes_dos_corretores"
        //     ],
        //     [
        //         "name" => "comissoes"
        //     ]
        // ];

        $dados = [
            [
                "name" => "configuracoes",
                "description" => "Configurações (Apenas Administrador)"
            ],
            [
                "name" => "clientes_dos_corretores",
                "description" => "Listar Todos os Clientes da Corretora (Apenas Administrador)"
            ],
            [
                "name" => "clientes",
                "description" => "Clientes"
            ],
            [
                "name" => "contratos",
                "description" => "Contratos"
            ],
            [
                "name" => "comissoes",
                "description" => "Comissões"
            ] 
           
        ];    



        Permission::insert($dados);
    }
}
