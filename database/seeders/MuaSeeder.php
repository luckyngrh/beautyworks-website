<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MuaSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('appointments')->insert([
            ['nama_mua' => 'Fifi',
            'no_telp' => '08111234567891',
            'spesialisasi' => 'Makeup Wedding, Makeup Reguler, Makeup Class',
            ],
            ['nama_mua' => 'Shafa',
            'no_telp' => '08121234567891',
            'spesialisasi' => 'Makeup Wedding, Makeup Reguler',
            ],
            ['nama_mua' => 'Tari',
            'no_telp' => '08131234567891',
            'spesialisasi' => 'Makeup Wedding',
            ],
        ]);
    }
}