<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RematriSekolah;
use Illuminate\Support\Facades\Auth;

class CheckDataRematri
{
    public function handle($request, Closure $next)
    {
        $rematri = RematriSekolah::where('sekolah_id', Auth::user()->sekolah_id)->get();
        if ($rematri->isEmpty()) {
            return redirect()->route('rematri.create');
        }

        return $next($request);
    }
}
