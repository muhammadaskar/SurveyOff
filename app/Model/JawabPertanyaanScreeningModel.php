<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JawabPertanyaanScreeningModel extends Model
{
    protected $table = 'jawab_pertanyaan_screening';
    protected $fillable = [
        'user_id',
        'pertanyaan_id',
        'jawaban',
    ];
}
