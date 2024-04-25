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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('person_id');
            $table->unsignedTinyInteger('address_type_id')->nullable();
            $table->string('address');
            // parroquia
            // municipio
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('address_type_id')->references('id')->on('address_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};