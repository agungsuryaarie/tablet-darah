<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiRematri extends Model
{
    use HasFactory;

    protected $table = "sesi_rematri";

    protected $fillable = ['sesi_id', 'rematri_id', 'foto', 'created_at'];

    public function rematri()
    {
        return $this->belongsTo(Rematri::class);
    }
}
