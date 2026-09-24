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
        Schema::create('tanques', function (Blueprint $table) {
            $table->id('id_tanque');
            $table->string('status', 25);
            $table->foreignId('id_usuario')->constrained('users', 'id_usuario')->onDelete('cascade');
            $table->string('tipo', 25);
            $table->date('datatanque_registrada');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanques');
    }
};
