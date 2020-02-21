<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetailPertanyaanModel extends Model
{
    protected $table = 'detail_pertanyaan';
    protected $fillable = [
        'pertanyaan_id',
        'pertanyaan',
        'j1',
        'j2',
        'j3',
        'j4',
    ];
}
