<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->date('data_nascimento');
            $table->string('turma');
            $table->enum('status', ['Pendente', 'Aprovado', 'Cancelado'])->default('Pendente');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
