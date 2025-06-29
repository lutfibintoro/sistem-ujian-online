<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataUjian extends Model
{
    use HasFactory;

    protected $table = 'data_ujian';
    protected $primaryKey = 'id_data_ujian';
    protected $fillable = [
        'id_data_ujian',
        'nama_ujian',
        'penjelasan_ujian',
        'durasi_ujian',
        'ujian_dibuka',
        'ujian_ditutup',
        'id_pelajaran'
    ];
}
