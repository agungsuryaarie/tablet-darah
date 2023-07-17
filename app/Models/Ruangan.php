<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = "ruangan";
    protected $fillable = ['sekolah_id', 'kelas_id', 'name'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function isFilled()
    {
        return !empty($this->name);
    }
}
