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
        Schema::create('employee_ccp', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ccp_id');
            $table->unsignedInteger('employee_id');
            $table->timestamps();

            $table->foreign('ccp_id')->references('id')->on('ccps');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_ccp');
    }
};
