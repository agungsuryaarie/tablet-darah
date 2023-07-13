<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class CheckDataKelas
{
    public function handle($request, Closure $next)
    {
        $kelas = Kelas::where('sekolah_id', Auth::user()->sekolah_id)->get();
        if ($kelas->isEmpty()) {
            return redirect()->route('kelas.index');
        }

        return $next($request);
    }
}
