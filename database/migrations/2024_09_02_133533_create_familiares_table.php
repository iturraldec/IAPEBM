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
        Schema::create('familiares', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('employee_id');
            $table->unsignedSmallInteger('parentesco_id');
            $table->string('first_name', 50);
            $table->string('second_name', 50)->nullable();
            $table->string('first_last_name', 50);
            $table->string('second_last_name', 50)->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('familiares');
    }
};
