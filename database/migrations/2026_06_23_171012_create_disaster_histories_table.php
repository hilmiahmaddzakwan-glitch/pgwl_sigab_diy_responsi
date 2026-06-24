<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disaster_histories', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bencana');
            $table->string('jenis_bencana');
            $table->date('tanggal_kejadian');
            $table->text('keterangan')->nullable();
            $table->text('coordinates'); // Menyimpan array koordinat polygon berbentuk JSON
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disaster_histories');
    }
};
