<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelajaran extends Model
{
    use HasFactory;

    protected $table = 'pelajaran';
    protected $primaryKey = 'id_pelajaran';
    public $timestamps = false;
    protected $fillable = [
        'nama_pelajaran'
    ];
}
