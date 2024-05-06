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
            $table->id();
            $table->unsignedInteger('person_id');
            $table->unsignedSmallInteger('grupo_id');
            $table->string('codigo', 20);
            $table->date('fecha_ingreso');
            $table->unsignedSmallInteger('employee_cargo_id')->nullable();
            $table->unsignedSmallInteger('employee_condicion_id')->nullable();
            $table->unsignedSmallInteger('employee_tipo_id')->nullable();
            $table->unsignedSmallInteger('employee_location_id')->nullable();
            $table->string('rif', 20);
            $table->string('codigo_patria', 20)->nullable();
            $table->string('religion');
            $table->string('deporte');
            $table->boolean('is_licencia')->default(false);
            $table->string('licencia_grado')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_cargo_id')->references('id')->on('employee_cargos')->nullOnDelete();
            $table->foreign('employee_condicion_id')->references('id')->on('employee_condiciones')->nullOnDelete();
            $table->foreign('employee_tipo_id')->references('id')->on('employee_tipos')->nullOnDelete();
            $table->foreign('employee_location_id')->references('id')->on('employee_locations')->nullOnDelete();
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