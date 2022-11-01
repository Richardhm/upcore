<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstagioClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estagio_clientes', function (Blueprint $table) {
            $table->id();
            $table->string("nome",255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estagio_clientes');
    }
}
