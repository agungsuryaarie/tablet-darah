<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HB extends Model
{
    use HasFactory;

    protected $table = "hb";
    protected $fillable = ['puskesmas_id', 'sekolah_id', 'rematri_id', 'tgl_cek', 'berat_badan', 'panjang_badan', 'hb'];

    public function rematri()
    {
        return $this->belongsTo(Rematri::class);
    }
}
