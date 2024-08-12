<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->json('start');
            $table->json('end');
            $table->json('waypoints');
            $table->double('distance');
            $table->double('elevation_gain');
            $table->integer('likes')->default(0);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('routes');
    }
};