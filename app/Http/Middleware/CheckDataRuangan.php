<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class CheckDataRuangan
{
    public function handle($request, Closure $next)
    {
        $ruangan = Ruangan::where('sekolah_id', Auth::user()->sekolah_id)->get();
        if ($ruangan->isEmpty()) {
            return redirect()->route('ruangan.index');
        }

        return $next($request);
    }
}
