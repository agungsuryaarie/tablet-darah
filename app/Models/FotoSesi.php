<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoSesi extends Model
{
    use HasFactory;

    protected $table = "foto_sesi";
    protected $fillable = ['kecamatan_id', 'puskesmas_id', 'sekolah_id', 'kelas_id', 'sesi_id', 'rematri_id', 'foto'];

    public function rematri()
    {
        return $this->belongsTo(Rematri::class);
    }
}
