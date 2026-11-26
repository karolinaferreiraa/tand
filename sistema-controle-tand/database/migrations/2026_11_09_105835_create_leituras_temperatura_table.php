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
        Schema::create('leituras_temperatura', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_sensores')
                ->constrained('sensores', 'id_sensores')
                ->cascadeOnDelete();

            $table->decimal('temperatura', 5, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leituras_temperatura');
    }
};
