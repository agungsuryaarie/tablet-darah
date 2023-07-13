<?php

namespace App\Http\Middleware;

use App\Models\Jurusan;
use Closure;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class CheckDataJurusan
{
    public function handle($request, Closure $next)
    {
        $jurusan = Jurusan::where('sekolah_id', Auth::user()->sekolah_id)->get();
        if ($jurusan->isEmpty()) {
            return redirect()->route('jurusan.index');
        }

        return $next($request);
    }
}
