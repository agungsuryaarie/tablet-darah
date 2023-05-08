<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    use HasFactory;

    protected $table = "puskesmas";

    protected $fillable = [
        'kecamatan_id', 'puskesmas'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
    public function userpuskes()
    {
        return $this->hasMany(UserPuskesmas::class);
    }
}
