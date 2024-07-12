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
        Schema::create('parroquias', function (Blueprint $table) {
            $table->unsignedMediumInteger('id_parroquia');
            $table->unsignedMediumInteger('id_municipio');
            $table->string('parroquia', 100);
            $table->primary('id_parroquia');

            $table->foreign('id_municipio')->references('id_municipio')->on('municipios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parroquias');
    }
};
