<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = "sekolah";

    protected $fillable = [
        'kecamatan_id',  'puskesmas_id', 'npsn', 'sekolah', 'jenjang', 'status'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }
    public function usersekolah()
    {
        return $this->hasMany(UserSekolah::class);
    }
}
