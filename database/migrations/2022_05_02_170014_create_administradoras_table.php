<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministradorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administradoras', function (Blueprint $table) {
            $table->id();
            $table->string("nome");
            $table->string("logo")->nullable();
            $table->string("vitalicio")->nullable();
            $table->string("premiacao_corretora")->nullable();
            $table->string("premiacao_corretor")->nullable();
            $table->integer('quantidade_parcelas')->nullable();
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
        Schema::dropIfExists('administradoras');
    }
}
