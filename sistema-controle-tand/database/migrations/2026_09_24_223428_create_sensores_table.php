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
        Schema::create('sensores', function (Blueprint $table) {
            $table->id('id_sensores');
            $table->foreignId('id_tanque')->constrained('tanques', 'id_tanque')->onDelete('cascade');
            $table->float('temperatura_real');
            $table->float('temperatura_min_tanque');
            $table->float('temperatura_max_tanque');
            $table->float('ph_min');
            $table->float('ph_max');
            $table->float('ph_real');
            $table->boolean('manutencao');
            $table->date('datasensores_registrada');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensores');
    }


};
