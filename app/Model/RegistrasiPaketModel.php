<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RegistrasiPaketModel extends Model
{
    protected $table = 'registrasi_paket';
    protected $fillable = [
        'user_id',
        'paket_id',
        'jumlah_responden',
        'bukti_bayar',
    ];
}
