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
        Schema::create('data_eksistings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatans_id')->constrained('kecamatans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('daftar_sekolahs_id')->constrained('daftar_sekolahs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('daftar_jabatans_id')->constrained('daftar_jabatans')->onUpdate('cascade')->onDelete('cascade');
            $table->string('vnip');
            $table->string('vnama_guru');
            $table->foreignId('jenis_gurus_id')->constrained('jenis_gurus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('mapels_id')->constrained('mapels')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('data_eksistings');
    }
};
