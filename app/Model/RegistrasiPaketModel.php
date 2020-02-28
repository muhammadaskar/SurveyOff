<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RegistrasiPaketModel extends Model
{
    protected $table = 'registrasi_paket';
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'paket_id',
        'jumlah_responden',
        'judul',
        'deskripsi',
        'amount',
        'status',
        'snap_token',
    ];

        /**
     * Set status to Pending
     *
     * @return void
     */
    public function setPending()
    {
        $this->attributes['status'] = 'pending';
        self::save();
    }

    /**
     * Set status to Success
     *
     * @return void
     */
    public function setSuccess()
    {
        $this->attributes['status'] = 'success';
        self::save();
    }

    /**
     * Set status to Failed
     *
     * @return void
     */
    public function setFailed()
    {
        $this->attributes['status'] = 'failed';
        self::save();
    }

    /**
     * Set status to Expired
     *
     * @return void
     */
    public function setExpired()
    {
        $this->attributes['status'] = 'expired';
        self::save();
    }
}
