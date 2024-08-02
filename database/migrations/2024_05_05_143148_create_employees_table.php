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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('person_id');
            $table->unsignedSmallInteger('type_id');
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('codigo_nomina', 20);
            $table->date('fecha_ingreso');
            $table->unsignedSmallInteger('cargo_id');
            $table->unsignedSmallInteger('condicion_id');
            $table->unsignedSmallInteger('tipo_id');
            $table->unsignedSmallInteger('unidad_id');
            $table->string('rif', 20);
            $table->string('codigo_patria', 20);
            $table->string('serial_patria', 20);
            $table->string('religion', 100);
            $table->string('deporte', 100);
            $table->string('licencia', 100);
            $table->string('cta_bancaria_nro', 30);
            $table->string('passport_nro', 20)->nullable();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('condicion_id')->references('id')->on('condiciones')->nullOnDelete();
            $table->foreign('tipo_id')->references('id')->on('tipos')->nullOnDelete();
            $table->foreign('unidad_id')->references('id')->on('unidades')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};