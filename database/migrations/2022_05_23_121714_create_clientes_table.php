<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            
            /** Pq esse campo, na tela de contrato poder buscar apenas os clientes do usuario logado no input do cliente(Preencher automaticamente os campos do cliente especifico) */
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cidade_id');
            $table->unsignedBigInteger('etiqueta_id');
            $table->string("nome");
            
            $table->string("telefone")->nullable();
            $table->string("email")->nullable();
            $table->string("cpf")->nullable();   
            $table->date("data_nascimento")->nullable();   
            $table->string("endereco")->nullable();
            $table->string("cnpj")->nullable();
            $table->string("nome_empresa")->nullable();
            
            $table->boolean('pessoa_fisica');
            $table->boolean('pessoa_juridica');
            
            
            $table->date("ultimo_contato")->nullable();
            $table->foreign('cidade_id')->references('id')->on('cidades');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('etiqueta_id')->references('id')->on('etiquetas');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
