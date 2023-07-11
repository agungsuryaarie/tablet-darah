<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\RematriSekolah;
use App\Models\Sekolah;
use App\Models\UserPosyandu;
use App\Models\UserPuskesmas;
use App\Models\UserSekolah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

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
        $rematri_count = RematriSekolah::where('sekolah_id', Auth::user()->sekolah_id)->count();
        $puskesmas_count = Puskesmas::withCount('rematri')->get();

        $auth = Auth::user()->role;

        if ($auth == 1) {
            return view('admin.dashboard.admin', compact('menu', 'puskesmas', 'sekolah', 'posyandu', 'user_puskes', 'puskesmas_count'));
        } elseif ($auth == 2) {
            return view('admin.dashboard.puskesmas', compact('menu', 'sekolah_puskes', 'posyandu_puskes', 'usersekolah_puskes', 'userposyandu_puskes'));
        } elseif ($auth == 3) {
            return view('admin.dashboard.sekolah', compact('menu', 'rematri_count'));
        } else {
            return view('admin.dashboard.posyandu', compact('menu', 'rematri_count'));
        }
    }

    public function puskesmas(Request $request)
    {
        if ($request->ajax()) {
            $data = Puskesmas::with('rematri')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('rematri', function ($data) {
                    return '<center>' . $data->rematri->count() . '</center>';
                })
                ->rawColumns(['rematri'])
                ->make(true);
        }
    }
}
