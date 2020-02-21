<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetailPertanyaanScreeningModel extends Model
{
    protected $table = 'detail_pertanyaan_screening';
    protected $fillable = [
        'pertanyaan_id',
        'pertanyaan',
        'j1',
        'j2',
        'j3',
        'j4',
    ];
}
