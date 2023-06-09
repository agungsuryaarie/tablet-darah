<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RematriPosyandu extends Model
{
    use HasFactory;

    protected $table = "rematri_posyandu";

    protected $fillable = [
        'rematri_id',
        'puskesmas_id',
        'posyandu_id',
    ];

    public function rematri()
    {
        return $this->belongsTo(Rematri::class);
    }
    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }
    public function posyandu()

    {
        return $this->belongsTo(Posyandu::class);
    }
}
