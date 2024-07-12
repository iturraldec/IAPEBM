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
            $table->unsignedSmallInteger('grupo_id');
            $table->string('codigo_nomina', 20);
            $table->date('fecha_ingreso');
            $table->unsignedSmallInteger('condicion_id')->nullable();
            $table->unsignedSmallInteger('tipo_id')->nullable();
            $table->unsignedSmallInteger('ccp_id')->nullable();
            $table->string('rif', 20);
            $table->string('codigo_patria', 20)->default('NO DEFINIDO');
            $table->string('serial_patria', 20)->default('NO DEFINIDO');
            $table->string('religion', 100)->default('NO DEFINIDO');
            $table->string('deporte', 100)->default('NO DEFINIDO');
            $table->string('licencia', 100)->default('NO DEFINIDO');
            $table->string('nro_cta_bancaria', 30)->default('NO DEFINIDO');
            $table->string('image_f')->nullable();
            $table->string('image_li')->nullable();
            $table->string('image_ld')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('condicion_id')->references('id')->on('condiciones')->nullOnDelete();
            $table->foreign('tipo_id')->references('id')->on('tipos')->nullOnDelete();
            $table->foreign('ccp_id')->references('id')->on('ccps_e')->nullOnDelete();
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