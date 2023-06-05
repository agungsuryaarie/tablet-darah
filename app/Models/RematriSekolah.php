<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RematriSekolah extends Model
{
    use HasFactory;

    protected $table = "rematri_sekolah";

    protected $fillable = [
        'rematri_id',
        'puskesmas_id',
        'sekolah_id',
        'jurusan_id',
        'kelas_id',
    ];
    public function rematri()
    {
        return $this->belongsTo(Rematri::class);
    }
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
