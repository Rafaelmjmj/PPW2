<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ator_filme', function (Blueprint $table) {
            $table->id();
            $table->string('papel', 45)->nullable();
            $table->foreignId('ator_id')->constrained('ator')->onDelete('cascade');
            $table->foreignId('filme_id')->constrained('filme')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('diretor_filme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diretor_id')->constrained('diretor')->onDelete('cascade');
            $table->foreignId('filme_id')->constrained('filme')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('produtor_filme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produtor_id')->constrained('produtor')->onDelete('cascade');
            $table->foreignId('filme_id')->constrained('filme')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('escritor_filme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escritor_id')->constrained('escritor')->onDelete('cascade');
            $table->foreignId('filme_id')->constrained('filme')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escritor_filme');
        Schema::dropIfExists('produtor_filme');
        Schema::dropIfExists('diretor_filme');
        Schema::dropIfExists('ator_filme');
    }
};
