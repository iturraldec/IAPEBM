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
        Schema::create('registro_entradas_salidas', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedInteger('employee_id');
            $table->timestamp('income')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('exit')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_entradas_salidas');
    }
};
