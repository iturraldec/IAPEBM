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
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('person_id');
            $table->unsignedTinyInteger('phone_type_id')->nullable();
            $table->string('number', 20);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('phone_type_id')->references('id')->on('phone_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};