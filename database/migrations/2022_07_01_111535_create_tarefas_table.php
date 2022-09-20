<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarefasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('motivo_id')->nullable();
            $table->date('data');
            $table->string('title');
            $table->text('descricao');
            
            $table->text('descricao_motivo')->nullable();
            $table->boolean('status');

            $table->boolean('visivel')->default(1);

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete("cascade");
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('motivo_id')->references('id')->on('tarefa_motivo_perdas')->onDelete("cascade");
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
        Schema::dropIfExists('tarefas');
    }
}
