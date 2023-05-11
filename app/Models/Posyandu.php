<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;

    protected $table = "posyandu";

    protected $fillable = [
        'kecamatan_id', 'desa_id', 'puskesmas_id', 'posyandu'
    ];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
