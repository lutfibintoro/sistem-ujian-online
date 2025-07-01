<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPendidikan extends Model
{
    use HasFactory;

    protected $table = 'user_pendidikan';
    protected $primaryKey = 'id_user_pendidikan';
    public $timestamps = false;
    protected $fillable = [
        'username',
        'pass',
        'peran',
        'id_guru',
        'id_siswa'
    ];
}
