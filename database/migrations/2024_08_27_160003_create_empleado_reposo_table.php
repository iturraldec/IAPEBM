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
        Schema::create('empleado_reposos', function (Blueprint $table) {
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('reposo_id');
            $table->date('desde');
            $table->date('hasta');
            $table->string('observacion')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('reposo_id')->references('id')->on('reposos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_reposos');
    }
};