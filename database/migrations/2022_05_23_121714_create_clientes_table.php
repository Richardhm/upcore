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
            $table->unsignedBigInteger('origem_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('estagio_id')->nullable();
            $table->boolean('lead')->default(1);
            $table->boolean('visivel')->default(1);
            // $table->integer("star")->nullable();
            $table->string("nome");
            
            $table->string("telefone")->nullable();
            $table->string("email")->nullable();
            $table->string("cpf")->nullable();   
            $table->date("data_nascimento")->nullable();   
            $table->string("endereco")->nullable();
            $table->string("cnpj")->nullable();
            $table->string("nome_empresa")->nullable();
            $table->string("telefone_empresa")->nullable();
            
            $table->string("responsavel_financeiro")->nullable();
            $table->string("cpf_financeiro")->nullable();
            //$table->string("endereco_financeiro")->nullable();

            $table->date("data_vigente")->nullable();   
            $table->decimal("valor_adesao",10,2)->nullable();   
            $table->date("data_boleto")->nullable();


            $table->boolean('pessoa_fisica');
            $table->boolean('pessoa_juridica');
            
            //$table->text('anotacoes')->nullable();
            
            $table->date("ultimo_contato")->nullable();
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete("cascade");
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('etiqueta_id')->references('id')->on('etiquetas')->onDelete("cascade");
            $table->foreign('origem_id')->references('id')->on('origems')->onDelete("cascade");
            $table->foreign('lead_id')->references('id')->on('leads')->onDelete("cascade");
            $table->foreign('estagio_id')->references('id')->on('estagio_clientes')->onDelete("cascade");

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
