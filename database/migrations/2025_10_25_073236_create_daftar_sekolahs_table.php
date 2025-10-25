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
        Schema::create('daftar_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatans_id')->constrained('kecamatans')->onUpdate('cascade')->onDelete('cascade');
            $table->string('vnama_sekolah');
            $table->string('vnpsn_sekolah');
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
        Schema::dropIfExists('daftar_sekolahs');
    }
};
