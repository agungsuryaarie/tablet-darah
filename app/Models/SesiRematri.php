<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiRematri extends Model
{
    use HasFactory;

    protected $table = "sesi_rematri";

    protected $fillable = ['rematri_id', 'sesi_id'];
}
