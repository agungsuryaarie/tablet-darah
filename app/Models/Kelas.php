<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = "kelas";
    protected $fillable = ['sekolah_id', 'nama', 'jurusan_id', 'ruangan'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
