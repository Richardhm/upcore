<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiacaoCorretoresLancadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premiacao_corretores_lancados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comissao_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('total',10,2);

            $table->foreign('comissao_id')->references('id')->on('comissoes');
            $table->foreign('user_id')->references('id')->on('comissoes');
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
        Schema::dropIfExists('premiacao_corretores_lancados');
    }
}
