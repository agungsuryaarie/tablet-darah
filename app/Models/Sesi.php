<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;

    protected $table = "sesi";
    protected $fillable = ['kecamatan_id', 'puskesmas_id', 'sekolah_id', 'nama', 'ruangan_id', 'kelas_id', 'created_at'];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function sesi_rematri()
    {
        return $this->belongsTo(SesiRematri::class);
    }
}
