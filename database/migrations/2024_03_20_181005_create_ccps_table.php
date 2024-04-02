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
        Schema::create('ccp_locations', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        //
        Schema::create('ccps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('ccp_location_id');
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->decimal('latitude', 9, 6);
            $table->decimal('length', 9, 6);
            $table->timestamps();

            $table->foreign('ccp_location_id')->references('id')->on('ccp_locations');
            $table->unique(['ccp_location_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ccp_locations');
        Schema::dropIfExists('ccps');
    }
};
