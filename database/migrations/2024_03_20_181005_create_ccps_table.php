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
        Schema::create('ccps_g', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        //
        Schema::create('ccps_e', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedTinyInteger('ccp_id');
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->decimal('latitude', 9, 6);
            $table->decimal('length', 9, 6);
            $table->timestamps();
            $table->unique(['code', 'name']);

            $table->foreign('ccp_id')->references('id')->on('ccps_g')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ccps_g');
        Schema::dropIfExists('ccps_e');
    }
};
