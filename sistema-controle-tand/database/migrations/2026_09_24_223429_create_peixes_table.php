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
        Schema::create('peixes', function (Blueprint $table) {
            $table->id('id_peixe');
            $table->float('temperatura_ideal_min');
            $table->float('temperatura_ideal_max');
            $table->foreignId('id_tanque')->constrained('tanques', 'id_tanque')->onDelete('cascade');
            $table->float('mortalidade_media');
            $table->integer('qtde_mortos');
            $table->date('datapeixe_registrada');
            $table->float('alimentacao_media');
            $table->boolean('alimentacao_no_dia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peixes');
    }
};
