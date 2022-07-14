<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissoesCorretoraConfiguracoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissoes_corretora_configuracoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('administradora_id');
            $table->unsignedBigInteger('corretora_id');
            
            $table->integer("parcela");
            
            $table->string("valor");
            $table->boolean("status")->default(0);
            $table->foreign('administradora_id')->references('id')->on('administradoras');
            $table->foreign('corretora_id')->references('id')->on('corretoras');
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
        Schema::dropIfExists('comissoes_corretora_configuracoes');
    }
}
