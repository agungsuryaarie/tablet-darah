<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    use HasFactory;

    protected $table = "puskesmas";

    protected $fillable = [
        'kecamatan_id', 'kode_puskesmas', 'puskesmas'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
    public function userpuskes()
    {
        return $this->hasMany(UserPuskesmas::class);
    }
    public function usersekolah()
    {
        return $this->hasMany(UserSekolah::class);
    }
    public function sekolah()
    {
        return $this->hasMany(Sekolah::class);
    }
    public function posyandu()
    {
        return $this->hasMany(Posyandu::class);
    }
    public function rematri()
    {
        return $this->hasMany(RematriSekolah::class);
    }
    public function sesi()
    {
        return $this->hasMany(SesiRematri::class);
    }
    public function rematrip()
    {
        return $this->hasMany(RematriP::class);
    }
}
