<?php

use FontLib\Table\Type\name;
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
        Schema::create('empleado_reposos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('reposo_id')->nullable();
            $table->date('desde');
            $table->date('hasta');
            $table->date('noti_fecha');
            $table->string('noti_dr_ci', 20);
            $table->string('noti_dr_nombre', 100);
            $table->string('noti_dr_mpps', 20);
            $table->string('noti_dr_cms', 20);
            $table->date('conva_fecha')->nullable();
            $table->string('conva_dr_ci', 20)->nullable();
            $table->string('conva_dr_nombre', 100)->nullable();
            $table->string('conva_dr_mpps', 20)->nullable();
            $table->string('conva_dr_cms', 20)->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('reposo_id')->references('id')->on('reposos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado_reposos');
    }
};