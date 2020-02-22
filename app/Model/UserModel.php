<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'tanggal_lahir',
        'jenis_kelamin',
        'password',
        'remeber_token',
    ];
    
}
