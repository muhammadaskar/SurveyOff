<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JawabPertanyaanModel extends Model
{
    protected $table = 'jawab_pertanyaan';
    protected $fillable = [
        'user_id',
        'pertanyaan_id',
        'jawaban',
    ];
}
