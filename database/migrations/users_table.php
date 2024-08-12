<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('name'); // User's name
            $table->string('email')->unique(); // User's email, unique
            $table->timestamp('email_verified_at')->nullable(); // Timestamp for email verification
            $table->string('password'); // Password field
            $table->rememberToken(); // Token for "remember me" functionality
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
