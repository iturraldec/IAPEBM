<?php

use App\Models\Employee;
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
        Schema::create('recibos_pagos', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('mes', 7);
            $table->date('desde');
            $table->date('hasta');
            $table->timestamps();
        });

        Schema::create('empleado_recibos_pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id');
            $table->unsignedSmallInteger('recibo_id');
            $table->float('ingreso');
            $table->float('egreso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibos_pagos');
        Schema::dropIfExists('empleado_recibos_pagos');
    }
};
