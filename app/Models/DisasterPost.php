<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterPost extends Model
{
    use HasFactory;

    protected $table = 'disaster_posts';

    protected $fillable = [
        'nama_pos',
        'jenis_pos',
        'deskripsi',
        'foto',
        'geom',
    ];
}
