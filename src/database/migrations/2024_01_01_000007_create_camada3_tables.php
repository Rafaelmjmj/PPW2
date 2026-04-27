<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_perfil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuario')->onDelete('cascade');
            $table->string('nome', 45);
            $table->string('caminho', 150);
            $table->timestamps();
        });

        Schema::create('imagem_estudio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imagem_id')->constrained('imagem')->onDelete('cascade');
            $table->foreignId('estudio_id')->constrained('estudio')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('filme', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 45);
            $table->integer('duracao')->nullable();
            $table->date('data_lancamento')->nullable();
            $table->string('classificacao', 45)->nullable();
            $table->text('sinopse')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filme');
        Schema::dropIfExists('imagem_estudio');
        Schema::dropIfExists('foto_perfil');
    }
};
