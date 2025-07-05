<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoalUjian extends Model
{
    use HasFactory;

    protected $table = 'soal_ujian';
    protected $primaryKey = 'id_soal_ujian';
    public $timestamps = false;
    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'j1',
        'j2',
        'j3',
        'j4',
        'j5',
        'j6',
        'j7',
        'j8',
        'j9',
        'j10',
        'id_guru',
        'id_data_ujian'
    ];
}
