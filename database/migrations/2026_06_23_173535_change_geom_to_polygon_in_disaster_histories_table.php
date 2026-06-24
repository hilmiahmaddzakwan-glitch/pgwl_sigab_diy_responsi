<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hapus kolom geom lama yang bertipe POINT
        DB::statement('ALTER TABLE disaster_histories DROP COLUMN IF EXISTS geom;');

        // 2. Buat kembali kolom geom dengan tipe data POLYGON (SRID 4326)
        DB::statement('ALTER TABLE disaster_histories ADD COLUMN geom geometry(Polygon, 4326);');
    }

    public function down(): void
    {
        // Kembalikan ke Point jika di-rollback
        DB::statement('ALTER TABLE disaster_histories DROP COLUMN IF EXISTS geom;');
        DB::statement('ALTER TABLE disaster_histories ADD COLUMN geom geometry(Point, 4326);');
    }
};
