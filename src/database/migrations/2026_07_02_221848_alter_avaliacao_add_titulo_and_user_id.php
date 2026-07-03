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
        // Remove FK para permitir mudar usuario_id para nullable
        Schema::table('avaliacao', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->bigInteger('usuario_id')->nullable()->change();
        });

        Schema::table('avaliacao', function (Blueprint $table) {
            $table->string('titulo', 255)->nullable()->after('usuario_id');
            $table->foreignId('user_id')->nullable()->after('titulo')
                  ->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('avaliacao', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['titulo', 'user_id']);
        });
    }
};
