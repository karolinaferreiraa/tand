<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tanques', function (Blueprint $table) {
            $table->string('nome', 80)->nullable();
            $table->string('dimensoes', 100)->nullable();
            $table->unsignedInteger('quantidade_alevinos')->nullable();
            $table->string('especie', 60)->nullable();
            $table->decimal('volume_estimado', 10, 2)->nullable();
        });

        Schema::table('sensores', function (Blueprint $table) {
            $table->float('temperatura_real')->nullable()->change();
            $table->float('temperatura_alerta_min')->nullable();
            $table->float('temperatura_alerta_max')->nullable();
            $table->float('temperatura_critica_min')->nullable();
            $table->float('temperatura_critica_max')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('sensores', function (Blueprint $table) {
            $table->dropColumn([
                'temperatura_alerta_min',
                'temperatura_alerta_max',
                'temperatura_critica_min',
                'temperatura_critica_max',
            ]);
            $table->float('temperatura_real')->nullable(false)->change();
        });

        Schema::table('tanques', function (Blueprint $table) {
            $table->dropColumn([
                'nome',
                'dimensoes',
                'quantidade_alevinos',
                'especie',
                'volume_estimado',
            ]);
        });
    }
};
