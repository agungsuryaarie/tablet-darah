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
        'nohp',
        'berat_badan',
        'panjang_badan',
        'agama',
        'jurusan_id',
        'kelas_id',
        'hb',
        'nama_ortu',
        'nik_ortu',
        'tlp_ortu',
        'kecamatan_id',
        'desa_id',
        'alamat',
    ];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
