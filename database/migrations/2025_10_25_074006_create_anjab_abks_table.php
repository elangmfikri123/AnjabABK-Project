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
        Schema::create('anjab_abks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatans_id')->constrained('kecamatans')->onUpdate('cascade')->onDelete('cascade'); // kecamatan
            $table->foreignId('daftar_sekolahs_id')->constrained('daftar_sekolahs')->onUpdate('cascade')->onDelete('cascade'); // sekolah
            $table->foreignId('daftar_jabatans_id')->constrained('daftar_jabatans')->onUpdate('cascade')->onDelete('cascade'); // jabatan
            $table->string('vkelas_jabatan'); // kebutuhan pegawai
            $table->integer('vkebutuhan_pegawai'); // kebutuhan pegawai
            $table->integer('vbeban_pegawai'); // beban pegawai
            $table->string('vketerangan'); // keterangan
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
        Schema::dropIfExists('anjab_abks');
    }
};
