<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\ListMua; 

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $primaryKey = 'id_appointment';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'id_mua',
        'jenis_layanan',
        'tanggal_appointment',
        'waktu_appointment',
        'kontak',
        'status'
    ];

    /**
     * Get the user that owns the appointment.
     * Seorang appointment dimiliki oleh satu user.
     * Relasi: Satu appointment dimiliki oleh satu user (Many to One).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Get the MUA (Makeup Artist) that owns the appointment.
     * Seorang appointment dimiliki oleh satu MUA.
     * Relasi: Satu appointment dimiliki oleh satu MUA (Many to One).
     */
    public function mua()
    {
        return $this->belongsTo(ListMua::class, 'id_mua', 'id_mua');
    }
}