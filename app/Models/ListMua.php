<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListMua extends Model
{
    use HasFactory;
    protected $table = 'list_muas';
    protected $primaryKey = 'id_mua';
    protected $fillable = [
        'nama_mua',
        'no_telp',
        'spesialisasi',
    ];
}
