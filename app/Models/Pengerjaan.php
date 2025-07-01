<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengerjaan extends Model
{
    use HasFactory;

    protected $table = 'pengerjaan';
    protected $primaryKey = 'id_pengerjaan';
    public $timestamps = false;
    protected $fillable = [
        'id_pengerjaan',
        'jawaban',
        'waktu_mulai',
        'id_soal_ujian',
        'id_siswa'
    ];
}
