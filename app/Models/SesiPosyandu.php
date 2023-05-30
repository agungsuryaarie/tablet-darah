<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiPosyandu extends Model
{
    use HasFactory;

    protected $table = "sesi_posyandu";
    protected $fillable = ['puskesmas_id', 'posyandu_id', 'nama'];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }
}
