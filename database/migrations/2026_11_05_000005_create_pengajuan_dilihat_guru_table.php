<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_dilihat_guru', function (Blueprint $table) {
            $table->foreignId('booking_id')->constrained('booking_konselings')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('gurus')->cascadeOnDelete();
            $table->timestamp('dilihat_at');
            $table->primary(['booking_id', 'guru_id']);
        });

        DB::table('booking_konselings as b')->join('jadwal_konselings as j', 'j.id', '=', 'b.jadwal_id')
            ->whereNotNull('b.dilihat_guru_at')->select('b.id', 'j.guru_id', 'b.dilihat_guru_at')
            ->orderBy('b.id')->chunk(500, function ($rows) {
                DB::table('pengajuan_dilihat_guru')->insert($rows->map(fn ($row) => [
                    'booking_id' => $row->id, 'guru_id' => $row->guru_id, 'dilihat_at' => $row->dilihat_guru_at,
                ])->all());
            });
        Schema::table('booking_konselings', fn (Blueprint $table) => $table->dropColumn('dilihat_guru_at'));
    }

    public function down(): void
    {
        Schema::table('booking_konselings', fn (Blueprint $table) => $table->timestamp('dilihat_guru_at')->nullable());
        foreach (DB::table('pengajuan_dilihat_guru')->get() as $view) {
            DB::table('booking_konselings')->where('id', $view->booking_id)->update(['dilihat_guru_at' => $view->dilihat_at]);
        }
        Schema::dropIfExists('pengajuan_dilihat_guru');
    }
};
