<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;

    protected $table = "posyandu";

    protected $fillable = [
        'desa_id', 'posyandu'
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
