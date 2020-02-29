<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RespondenModel extends Model
{
    protected $table = 'responden';
    protected $fillable = [
        'user_id',
        'no_rek',
        'type_rek',
    ];
}
