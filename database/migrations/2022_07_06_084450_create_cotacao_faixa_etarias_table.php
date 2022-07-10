<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotacaoFaixaEtariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacao_faixa_etarias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cotacao_id')->nullable();
            $table->unsignedBigInteger('faixa_etaria_id');
            $table->integer("quantidade");
            $table->timestamps();
            $table->foreign('cotacao_id')->references('id')->on('cotacoes')->onDelete('cascade');
            $table->foreign('faixa_etaria_id')->references('id')->on('faixas_etarias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotacao_faixa_etarias');
    }
}
