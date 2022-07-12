<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministradoraPremiacoesComissoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administradora_premiacoes_comissoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('administradora_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('plano_id')->nullable();
            $table->boolean("corretora")->nullable();
            $table->boolean("premiacao")->nullable();
            $table->boolean("comissao")->nullable();
            $table->boolean("user")->nullable();


            $table->decimal("valor",10,2);
            $table->date('data')->nullable();
            $table->integer("ordem")->nullable();
            
            $table->integer("quantidade_parcelas")->nullable();

            $table->foreign('administradora_id')->references('id')->on('administradoras');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('plano_id')->references('id')->on('planos');
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
        Schema::dropIfExists('administradora_premiacoes_comissoes');
    }
}
