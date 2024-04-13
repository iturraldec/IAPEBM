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
            $table->string('nombre', 200);
            $table->char('sexo', 1);
            $table->date('fecha_nacimiento');
            $table->text('lugar_nacimiento');
            $table->text('direccion');
            $table->timestamps();
            $table->softDeletes();
        });

        //
        Schema::create('person_phone', function (Blueprint $table) {
            $table->unsignedInteger('person_id');
            $table->unsignedInteger('phone_id');

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('phone_id')->references('id')->on('phones')->onDelete('cascade');
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
