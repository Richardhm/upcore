<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('cidade_id');
            $table->unsignedBigInteger('operadora_id')->nullable();
            $table->unsignedBigInteger('administradora_id')->nullable();
            $table->unsignedBigInteger('acomodacao_id')->nullable();
            $table->unsignedBigInteger('plano_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('corretora_id');
            $table->unsignedBigInteger("financeiro_id")->nullable();
            $table->string("codigo_externo")->nullable();
            $table->decimal("valor",10,2)->nullable();
            $table->boolean('coparticipacao')->default(0);
            $table->boolean('odonto')->default(0);
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete("cascade");
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete("cascade");
            $table->foreign('operadora_id')->references('id')->on('operadoras')->onDelete("cascade");
            $table->foreign('administradora_id')->references('id')->on('administradoras')->onDelete("cascade");
            $table->foreign('acomodacao_id')->references('id')->on('acomodacao')->onDelete("cascade");
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('corretora_id')->references('id')->on('corretoras')->onDelete("cascade");
            $table->foreign('financeiro_id')->references('id')->on('financeiros')->onDelete("cascade");
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete("cascade");
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
        Schema::dropIfExists('cotacoes');
    }
}
