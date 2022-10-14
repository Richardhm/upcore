<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiacaoCorretoresConfiguracoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premiacao_corretores_configuracoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plano_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('administradora_id');
            $table->unsignedBigInteger('cidade_id');
            
            $table->string('valor');
            $table->integer('parcela');
            
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete("cascade");
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('administradora_id')->references('id')->on('administradoras')->onDelete("cascade");
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete("cascade");

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
        Schema::dropIfExists('premiacao_corretores_configuracoes');
    }
}
