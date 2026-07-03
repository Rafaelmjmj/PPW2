<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('imagem', function (Blueprint $table) {
            $table->string('caminho', 500)->change();
            $table->string('nome', 255)->change();
        });
    }

    public function down(): void
    {
        Schema::table('imagem', function (Blueprint $table) {
            $table->string('caminho', 150)->change();
            $table->string('nome', 45)->change();
        });
    }
};
