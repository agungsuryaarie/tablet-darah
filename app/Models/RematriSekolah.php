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
        'ruangan_id',
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
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function isFilled()
    {
        return !empty($this->rematri_id);
    }
}
