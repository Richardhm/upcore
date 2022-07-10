<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentoFaixaEtariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamento_faixa_etarias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orcamento_id')->nullable();
            $table->unsignedBigInteger('faixa_etaria_id');
            $table->integer("quantidade");
            $table->timestamps();
            $table->foreign('orcamento_id')->references('id')->on('orcamentos');
            $table->foreign('faixa_etaria_id')->references('id')->on('faixas_etarias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orcamento_faixa_etarias');
    }
}
