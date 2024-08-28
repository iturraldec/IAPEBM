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
        Schema::create('police_rangos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('police_id');
            $table->unsignedSmallInteger('rango_id');
            $table->date('documento_fecha');
            $table->string('documento_file')->nullable();
            $table->timestamps();

            $table->foreign('police_id')->references('id')->on('police')->onDelete('cascade');
            $table->foreign('rango_id')->references('id')->on('rangos')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_rangos');
    }
};
