<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->text('alamat')->nullable();
            $table->string('no_hp', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'no_hp']);
        });
    }
};
