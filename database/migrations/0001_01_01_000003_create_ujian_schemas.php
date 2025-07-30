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
        Schema::create('pelajaran', function (Blueprint $table) {
            $table->id('id_pelajaran');
            $table->string('nama_pelajaran', 60);
        });

        Schema::create('data_ujian', function (Blueprint $table) {
            $table->id('id_data_ujian');
            $table->string('nama_ujian', 60)->nullable();
            $table->text('penjelasan_ujian')->nullable();
            $table->integer('durasi_ujian')->default(120);
            $table->dateTime('ujian_dibuka')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('ujian_ditutup')->nullable();
            $table->unsignedBigInteger('id_pelajaran');

            $table->foreign('id_pelajaran')
                  ->references('id_pelajaran')
                  ->on('pelajaran')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });

        Schema::create('guru', function (Blueprint $table) {
            $table->id('id_guru');
            $table->string('nama', 60);
            $table->string('kontak', 20)->nullable();
            $table->string('email', 60)->nullable();
        });

        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->string('nama', 60)->nullable();
            $table->string('kontak', 20)->nullable();
            $table->string('email', 60)->nullable();
        });

        Schema::create('user_pendidikan', function (Blueprint $table) {
            $table->id('id_user_pendidikan');
            $table->string('username', 60)->unique();
            $table->string('pass', 60);
            $table->enum('peran', ['siswa', 'guru'])->default('siswa');
            $table->dateTime('tanggal_dibuat')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('id_guru')->nullable();
            $table->unsignedBigInteger('id_siswa')->nullable();

            $table->foreign('id_guru')
                  ->references('id_guru')
                  ->on('guru')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreign('id_siswa')
                  ->references('id_siswa')
                  ->on('siswa')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });

        Schema::create('soal_ujian', function (Blueprint $table) {
            $table->id('id_soal_ujian');
            $table->text('pertanyaan')->nullable();
            $table->enum('jawaban', ['1','2','3','4','5','6','7','8','9','10'])->default('1');
            for ($i = 1; $i <= 10; $i++) {
                $table->text("j$i")->nullable();
            }
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_data_ujian');

            $table->foreign('id_guru')
                  ->references('id_guru')
                  ->on('guru')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreign('id_data_ujian')
                  ->references('id_data_ujian')
                  ->on('data_ujian')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });

        Schema::create('pengerjaan', function (Blueprint $table) {
            $table->id('id_pengerjaan');
            $table->enum('jawaban', ['1','2','3','4','5','6','7','8','9','10','11'])->default('11');
            $table->dateTime('waktu_mulai')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('id_soal_ujian');
            $table->unsignedBigInteger('id_siswa');

            $table->foreign('id_soal_ujian')
                  ->references('id_soal_ujian')
                  ->on('soal_ujian')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();

            $table->foreign('id_siswa')
                  ->references('id_siswa')
                  ->on('siswa')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengerjaan');
        Schema::dropIfExists('soal_ujian');
        Schema::dropIfExists('user_pendidikan');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('guru');
        Schema::dropIfExists('data_ujian');
        Schema::dropIfExists('pelajaran');
    }
};
