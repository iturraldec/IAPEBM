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
        //
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cedula',15)->nullable()->unique();
            $table->string('name', 200);
            $table->char('sex', 1);
            $table->date('birthday')->nullable();
            $table->text('place_of_birth')->nullable();
            $table->unsignedTinyInteger('civil_status_id')->nullable();
            $table->unsignedTinyInteger('blood_type_id')->nullable();
            $table->text('notes')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('civil_status_id')->references('id')->on('civil_status')->nullOnDelete();
            $table->foreign('blood_type_id')->references('id')->on('blood_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
