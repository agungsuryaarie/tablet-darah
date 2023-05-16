<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;

    protected $table = "sesi";
    protected $fillable = ['kecamatan_id', 'puskesmas_id', 'sekolah_id', 'nama', 'jurusan_id', 'kelas_id'];

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
}
