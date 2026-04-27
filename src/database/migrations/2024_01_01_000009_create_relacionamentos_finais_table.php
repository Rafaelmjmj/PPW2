<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filme_genero', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filme_id')->constrained('filme')->onDelete('cascade');
            $table->foreignId('genero_id')->constrained('genero')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('estudio_filme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudio_id')->constrained('estudio')->onDelete('cascade');
            $table->foreignId('filme_id')->constrained('filme')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('imagem_filme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filme_id')->constrained('filme')->onDelete('cascade');
            $table->foreignId('imagem_id')->constrained('imagem')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('avaliacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filme_id')->constrained('filme')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('usuario')->onDelete('cascade');
            $table->integer('nota');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacao');
        Schema::dropIfExists('imagem_filme');
        Schema::dropIfExists('estudio_filme');
        Schema::dropIfExists('filme_genero');
    }
};
