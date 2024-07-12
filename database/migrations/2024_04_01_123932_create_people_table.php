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
            $table->string('first_name', 50);
            $table->string('second_name', 50)->nullable();
            $table->string('first_last_name', 50);
            $table->string('second_last_name', 50)->nullable();
            $table->char('sex', 1);
            $table->date('birthday')->nullable();
            $table->text('place_of_birth')->nullable();
            $table->unsignedTinyInteger('civil_status_id')->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->text('notes')->nullable();
            $table->string('imagef')->nullable();
            $table->string('imageli')->nullable();
            $table->string('imageld')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
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
