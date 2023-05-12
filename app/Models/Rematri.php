<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rematri extends Model
{
    use HasFactory;

    protected $table = "rematri";

    protected $fillable = [
        'puskesmas_id',
        'sekolah_id',
        'anak_ke',
        'tempat_lahir',
        'tgl_lahir',
        'nokk',
        'nik',
        'nama',
        'berat_badan',
        'panjang_badan',
        'hb',
        'nama_ortu',
        'nik_ortu',
        'tlp_ortu',
        'kecamatan_id',
        'desa_id',
        'alamat',
    ];
}
