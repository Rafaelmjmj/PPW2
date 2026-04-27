<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pessoa', function (Blueprint $table) {
            $table->id();
            $table->string('cpf', 45)->unique();
            $table->string('nome', 45);
            $table->date('data_nascimento');
            $table->text('biografia')->nullable();
            $table->string('genero', 10)->nullable();
            $table->string('nacionalidade', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pessoa');
    }
};
