<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagem', function (Blueprint $table) {
            $table->id();
            $table->string('caminho', 150);
            $table->string('nome', 45);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagem');
    }
};
