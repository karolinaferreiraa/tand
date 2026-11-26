<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mortalidades', function (Blueprint $table) {
            $table->id('id_mortalidade');
            $table->foreignId('id_tanque')->constrained('tanques', 'id_tanque')->cascadeOnDelete();
            $table->unsignedInteger('quantidade');
            $table->text('observacao')->nullable();
            $table->date('ocorrido_em');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mortalidades');
    }
};
