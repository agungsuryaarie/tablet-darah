<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = "sekolah";

    protected $fillable = [
        'kabupaten_id', 'npsn', 'sekolah', 'jenjang', 'status'
    ];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}
