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
        Schema::table('prediksi_jurusans', function (Blueprint $table) {
            $table->string('jalur', 20)->nullable()->after('siswa_id');
            $table->json('hasil_detail')->nullable()->after('rekomendasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prediksi_jurusans', function (Blueprint $table) {
            $table->dropColumn(['jalur', 'hasil_detail']);
        });
    }
};

