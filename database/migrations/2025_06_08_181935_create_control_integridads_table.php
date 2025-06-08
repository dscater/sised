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
        Schema::create('control_integridads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("evidencia_id");
            $table->date("fecha_alteracion");
            $table->time("hora_alteracion");
            $table->string("encriptado_original");
            $table->string("encriptado_alteracion");
            $table->date("fecha_registro")->nullable();
            $table->timestamps();

            $table->foreign("evidencia_id")->on("evidencias")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_integridads');
    }
};
