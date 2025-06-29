<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoalUjian extends Model
{
    use HasFactory;

    protected $table = 'soal_ujian';
    protected $primaryKey = 'id_soal_ujian';
    protected $fillable = [
        'id_soal_ujian',
        'pertanyaan',
        'jawaban',
        'id_guru',
        'id_data_ujian'
    ];
}
