<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kelas extends Model
{
    use HasFactory;

    protected $table = "kelas";
    protected $fillable = ['sekolah_id', 'nama'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
    public function rematri()
    {
        return $this->hasMany(Rematri::class);
    }
    public function jumlahrematri()
    {
        $rematri = DB::table('rematri')->count();
        return $rematri;
    }
    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }
    public function isFilled()
    {
        return !empty($this->nama);
    }
}
