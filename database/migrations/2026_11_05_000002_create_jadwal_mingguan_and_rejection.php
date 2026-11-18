<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jadwal_mingguans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->cascadeOnDelete();
            $table->unsignedTinyInteger('hari'); // ISO weekday: Monday=1
            $table->time('jam_mulai');
            $table->timestamps();
            $table->unique(['guru_id', 'hari', 'jam_mulai']);
        });
        Schema::table('booking_konselings', function (Blueprint $table) {
            $table->string('jenis_jadwal')->default('tetap');
            $table->text('alasan_penolakan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('booking_konselings', function (Blueprint $table) {
            $table->dropColumn(['jenis_jadwal', 'alasan_penolakan']);
        });
        Schema::dropIfExists('jadwal_mingguans');
    }
};
