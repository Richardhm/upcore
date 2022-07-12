<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissoesVendedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissoes_vendedor', function (Blueprint $table) {
            $table->id();          
            $table->unsignedBigInteger('comissao_id');
            $table->foreign('comissao_id')->references('id')->on('comissoes');
            $table->integer("parcela");
            $table->date("data");
            $table->decimal("valor",10,2);
            $table->boolean("status")->default(0);
            
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
        Schema::dropIfExists('comissoes_vendedor');
    }
}
