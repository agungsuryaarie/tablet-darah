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
        'email',
        'tempat_lahir',
        'tgl_lahir',
        'nokk',
        'nik',
        'nama',
        'nohp',
        'berat_badan',
        'panjang_badan',
        'agama',
        'kelas_id',
        'jurusan_id',
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

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    // public function sesi()
    // {
    //     return $this->belongsToMany(Sesi::class);
    // }
    public function hb()
    {
        return $this->hasMany(HB::class);
    }
}
