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
}