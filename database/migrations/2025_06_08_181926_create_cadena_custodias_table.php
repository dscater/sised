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
        Schema::create('cadena_custodias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("evidencia_id");
            $table->string("responsable", 300);
            $table->string("cargo");
            $table->string("accion");
            $table->string("destino");
            $table->date("fecha");
            $table->time("hora");
            $table->text("observaciones");
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
        Schema::dropIfExists('cadena_custodias');
    }
};
