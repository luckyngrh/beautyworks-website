<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 
use App\Models\ListMua; 

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'id_reservation';
    public $timestamps = true;
    protected $fillable = [
        'id_midtrans',
        'nama',
        'kontak',
        'nama_mua',
        'jenis_layanan',
        'tanggal_reservation',
        'waktu_reservation',
        'status'
    ];

    /**
     * Get the user that owns the reservation.
     * Seorang reservation dimiliki oleh satu user.
     * Relasi: Satu reservation
     * dimiliki oleh satu user (Many to One).
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