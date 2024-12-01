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
            $table->string('rif', 20)->nullable();
            $table->string('codigo_patria', 20)->nullable();
            $table->string('serial_patria', 20)->nullable();
            $table->string('religion', 100)->nullable();
            $table->string('deporte', 100)->nullable();
            $table->string('licencia', 100)->nullable();
            $table->string('cta_bancaria_nro', 30)->nullable();
            $table->string('passport_nro', 20)->nullable();
            $table->string('fisio_barba', 20)->nullable();
            $table->string('fisio_bigote', 20)->nullable();
            $table->string('fisio_boca', 20)->nullable();
            $table->string('fisio_cabello', 20)->nullable();
            $table->string('fisio_cara', 20)->nullable();
            $table->string('fisio_tez', 20)->nullable();
            $table->string('fisio_contextura', 20)->nullable();
            $table->string('fisio_dentadura', 20)->nullable();
            $table->string('fisio_estatura', 20)->nullable();
            $table->string('fisio_frente', 20)->nullable();
            $table->string('fisio_labios', 20)->nullable();
            $table->string('fisio_lentes', 20)->nullable();
            $table->string('fisio_nariz', 20)->nullable();
            $table->string('fisio_ojos', 20)->nullable();
            $table->string('fisio_peso', 20)->nullable();
            $table->string('fisio_calzado', 20)->nullable();
            $table->string('fisio_camisa', 20)->nullable();
            $table->string('fisio_gorra', 20)->nullable();
            $table->string('fisio_pantalon', 20)->nullable();
            $table->string('fisio_otros')->nullable();

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