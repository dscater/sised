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
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();
            $table->string("codigo")->unique();
            $table->text("descripcion");
            $table->string("nombre_creador", 300);
            $table->date("fecha_creacion");
            $table->time("hora_creacion");
            $table->string("origen_archivo", 800);
            $table->date("fecha_hallazgo");
            $table->time("hora_hallazgo");
            $table->string("lugar_recoleccion", 800);
            $table->string("persona_recolector", 300);
            $table->string("herramienta_utilizada", 300);
            $table->date("fecha_registro")->nullable();
            $table->integer("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};
