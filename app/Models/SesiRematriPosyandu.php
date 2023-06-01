<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiRematriPosyandu extends Model
{
    use HasFactory;

    protected $table = "sesi_rematri_posyandu";

    protected $fillable = ['sesi_posyandu_id', 'posyandu_id', 'rematri_posyandu_id', 'foto'];

    public function rematri_posyandu()
    {
        return $this->belongsTo(RematriPosyandu::class);
    }
}
