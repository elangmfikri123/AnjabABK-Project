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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('role');
            $table->foreignId('daftar_sekolahs_id')->nullable()->constrained('daftar_sekolahs')->onUpdate('cascade')->onDelete('cascade');
            $table->string('login_token')->nullable(); 
            $table->timestamps();
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
