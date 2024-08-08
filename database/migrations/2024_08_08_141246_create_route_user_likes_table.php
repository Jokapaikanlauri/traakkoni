<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('route_user_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure a user can only like a route once
            $table->unique(['user_id', 'route_id']);
        });
    }

    public function down() {
        Schema::dropIfExists('route_user_likes');
    }
};
