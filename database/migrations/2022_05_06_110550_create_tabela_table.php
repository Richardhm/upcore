<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operadora_id');
            $table->unsignedBigInteger('administradora_id');
            $table->unsignedBigInteger('corretora_id');
            $table->unsignedBigInteger('cidade_id');
            $table->unsignedBigInteger('plano_id');
            $table->string('modelo');
            
            $table->boolean('coparticipacao');
            $table->boolean('odonto');
            $table->string('faixa_etaria');
            $table->decimal('valor',8,2);
            $table->timestamps();
            $table->foreign('operadora_id')->references('id')->on('operadoras')->onDelete('cascade');
            $table->foreign('administradora_id')->references('id')->on('administradoras')->onDelete('cascade');
            $table->foreign('corretora_id')->references('id')->on('corretoras')->onDelete('cascade');
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete('cascade');
            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabelas');
    }
}
