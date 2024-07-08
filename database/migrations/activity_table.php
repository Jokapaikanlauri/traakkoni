<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->double('start')->nullable();
            $table->double('end')->nullable();
            $table->json('waypoints');  // Waypoints as a JSON array
            $table->double('distance')->nullable();  // Total distance in kilometers
            $table->double('elevation_gain')->nullable();  // Total elevation gain in meters
            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
};
