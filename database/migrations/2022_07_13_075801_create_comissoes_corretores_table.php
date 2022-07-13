<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissoesCorretoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissoes_corretores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plano_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('administradora_id');
            
            $table->string('valor');
            $table->integer('parcela');
            $table->foreign('plano_id')->references('id')->on('planos');
            $table->foreign('user_id')->references('id')->on('planos');
            $table->foreign('administradora_id')->references('id')->on('administradoras');
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
        Schema::dropIfExists('comissoes_corretores');
    }
}
