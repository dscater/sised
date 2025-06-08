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
        Schema::create('evidencia_archivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("evidencia_id");
            $table->string("archivo", 255);
            $table->string("hash_archivo", 800);
            $table->timestamps();

            $table->foreign("evidencia_id")->on("evidencias")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencia_archivos');
    }
};
