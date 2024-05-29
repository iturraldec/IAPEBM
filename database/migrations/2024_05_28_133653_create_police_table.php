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
        Schema::create('police', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id');
            $table->string('escuela', 100)->nullable();
            $table->date('fecha_graduacion')->nullable();
            $table->string('curso', 10)->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('police');
    }
};
