<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
    $table->foreignId('siswa_id');
    $table->date('tanggal');
    $table->time('waktu');
    $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa']);
    $table->text('keterangan')->nullable();
    $table->boolean('is_confirmed')->default(false);
    $table->foreignId('confirmed_by')->nullable()->constrained('users');
    $table->timestamps();

    // Tambahkan foreign key constraint secara manual
    $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};