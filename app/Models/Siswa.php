<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    public $timestamps = false;
    protected $fillable = [
        'id_siswa',
        'nama',
        'kontak',
        'email'
    ];
}
