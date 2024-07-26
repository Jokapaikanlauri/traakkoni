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
            $table->unsignedBigInteger('user_id'); // Add user_id column
            $table->string('name')->nullable();
            $table->json('start')->nullable();
            $table->json('end')->nullable();
            $table->json('waypoints');  // Waypoints as a JSON array
            $table->double('distance')->nullable();  // Total distance in kilometers
            $table->double('elevation_gain')->nullable();  // Total elevation gain in meters
            $table->timestamps();  // Created at and updated at timestamps

            // Add foreign key constraint to ensure referential integrity
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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