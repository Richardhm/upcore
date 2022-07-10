<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('cidade_id');
            $table->unsignedBigInteger('operadora_id');
            $table->unsignedBigInteger('administradora_id');
            $table->unsignedBigInteger('orcamento_id')->nullable();
            $table->unsignedBigInteger('acomodacao_id');
            $table->unsignedBigInteger('user_id');
            $table->string("codigo_externo");
            $table->decimal("valor",10,2);
            $table->string("status");
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('cidade_id')->references('id')->on('cidades');
            $table->foreign('operadora_id')->references('id')->on('operadoras');
            $table->foreign('administradora_id')->references('id')->on('administradoras');
            $table->foreign('orcamento_id')->references('id')->on('orcamentos');
            $table->foreign('acomodacao_id')->references('id')->on('acomodacao');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('contratos');
    }
}
