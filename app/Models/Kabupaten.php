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
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }
    public function userpuskes()
    {
        return $this->hasMany(UserPuskesmas::class);
    }
}
