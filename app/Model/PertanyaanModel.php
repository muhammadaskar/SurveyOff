<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PertanyaanModel extends Model
{
    protected $table = 'pertanyaan';
    protected $fillable = [
        'registrasi_paket_id',
        'judul',
        'deskripsi'
    ];
}
