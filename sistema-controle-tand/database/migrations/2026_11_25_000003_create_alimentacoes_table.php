<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alimentacoes', function (Blueprint $table) {
            $table->id('id_alimentacao');
            $table->foreignId('id_tanque')->constrained('tanques', 'id_tanque')->cascadeOnDelete();
            $table->decimal('quantidade_kg', 8, 2);
            $table->string('tipo_racao', 80);
            $table->dateTime('registrado_em');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alimentacoes');
    }
};
