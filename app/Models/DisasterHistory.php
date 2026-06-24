<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterHistory extends Model
{
    use HasFactory;

    // Tambahkan 'geom' ke dalam array agar diizinkan masuk ke database
    protected $fillable = [
        'nama_bencana',
        'jenis_bencana',
        'tanggal_kejadian',
        'keterangan',
        'foto',
        'geom',
    ];
}
