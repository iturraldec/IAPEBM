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
        Schema::create('unidades', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('eje_id')->nullable();
            $table->unsignedSmallInteger('padre_id')->nullable();
            $table->string('code', 20);
            $table->string('name');
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('length', 9, 6)->nullable();
            $table->timestamps();

            $table->unique(['code', 'name']);
            $table->foreign('padre_id')->references('id')->on('unidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades');
    }
};