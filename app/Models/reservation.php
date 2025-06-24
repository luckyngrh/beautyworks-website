<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'id_reservation';
    public $timestamps = true;
    protected $fillable = [
        'id_midtrans', // Pastikan kolom ini ada di fillable
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
}

