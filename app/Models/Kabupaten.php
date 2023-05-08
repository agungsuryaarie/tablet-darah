<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = "kabupaten";

    protected $fillable = [
        'kode_wilayah', 'kabupaten'
    ];

    public function sekolah()
    {
        return $this->hasMany(Sekolah::class);
    }
}
