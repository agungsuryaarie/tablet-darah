<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\Sekolah;
use App\Models\User;
use App\Models\UserPosyandu;
use App\Models\UserPuskesmas;
use App\Models\UserSekolah;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {

        $menu = "Dashboard";
        $puskesmas = Puskesmas::count();
        $sekolah = Sekolah::count();
        $sekolah_puskes = Sekolah::where('puskesmas_id', Auth::user()->puskesmas_id)->count();
        $posyandu = Posyandu::count();
        $posyandu_puskes = Posyandu::where('puskesmas_id', Auth::user()->puskesmas_id)->count();
        $user_puskes = UserPuskesmas::count();
        $usersekolah_puskes = UserSekolah::where('puskesmas_id', Auth::user()->puskesmas_id)->count();
        $userposyandu_puskes = UserPosyandu::where('puskesmas_id', Auth::user()->puskesmas_id)->count();
        // $user = User::where('role', '!=', 1)->count();
        return view('admin.dashboard', compact('menu', 'puskesmas', 'sekolah', 'sekolah_puskes', 'posyandu', 'posyandu_puskes', 'user_puskes', 'usersekolah_puskes', 'userposyandu_puskes'));
    }
}
