<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{

    protected $table = 'mahasiswa';
    protected $fillable = [
        'nim',
        'nama',
        'jurusan',
    ];
}
