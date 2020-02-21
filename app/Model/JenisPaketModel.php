<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JenisPaketModel extends Model
{
    protected $table = 'jenis_paket';
    protected $fillable = [
        'jumlah_pertanyaan',
        'jumlah_hari',
        'pendapatan',
    ];

}
