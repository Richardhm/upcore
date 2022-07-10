<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministradoraParcelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administradora_parcelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('administradora_id');
            $table->decimal("valor",10,2);
            $table->integer("ordem");
            
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
        Schema::dropIfExists('administradora_parcelas');
    }
}
