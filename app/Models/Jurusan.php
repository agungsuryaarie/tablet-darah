<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = "jurusan";
    protected $fillable = ['sekolah_id', 'kelas_id', 'nama', 'ruangan'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
