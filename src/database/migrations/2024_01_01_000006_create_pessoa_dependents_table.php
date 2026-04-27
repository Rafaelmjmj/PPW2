<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoa')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('diretor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoa')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('produtor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoa')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('escritor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoa')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('imagem_pessoa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imagem_pessoa_id')->constrained('pessoa')->onDelete('cascade');
            $table->foreignId('imagem_id')->constrained('imagem')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagem_pessoa');
        Schema::dropIfExists('escritor');
        Schema::dropIfExists('produtor');
        Schema::dropIfExists('diretor');
        Schema::dropIfExists('ator');
    }
};
