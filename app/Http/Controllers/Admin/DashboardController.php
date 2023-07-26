<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\RematriSekolah;
use App\Models\Sekolah;
use App\Models\Sesi;
use App\Models\SesiRematri;
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
            $rematriDataS = Sekolah::select('sekolah.sekolah as sekolah_nama', \DB::raw('COUNT(rematri_sekolah.id) as rematri_count'))
                ->leftJoin('rematri_sekolah', 'sekolah.id', '=', 'rematri_sekolah.sekolah_id')
                ->groupBy('sekolah.id', 'sekolah.sekolah')
                ->get();
            // dd($rematriDataS);
            $rematriData = Puskesmas::select('puskesmas.puskesmas as puskesmas_nama', \DB::raw('COUNT(rematri_sekolah.id) as rematri_count'))
                ->leftJoin('sekolah', 'puskesmas.id', '=', 'sekolah.puskesmas_id')
                ->leftJoin('rematri_sekolah', 'sekolah.id', '=', 'rematri_sekolah.sekolah_id')
                ->groupBy('puskesmas.id', 'puskesmas.puskesmas')
                ->get();
            // dd($rematriData);
            return view('admin.dashboard.admin', compact('menu', 'puskesmas', 'sekolah', 'posyandu', 'user_puskes', 'puskesmas_count', 'rematriData', 'rematriDataS'));
        } elseif ($auth == 2) {
            $bulan = Sesi::with('sesi_rematri')
                ->selectRaw("DATE_FORMAT(sesi.created_at, '%b') as nama_bulan, MONTH(sesi.created_at) as bulan")
                ->where('puskesmas_id', '=', Auth::user()->puskesmas_id)
                ->groupBy('nama_bulan', 'bulan')
                ->orderBy('bulan')
                ->get();

            $puskesmas_id = Auth::user()->puskesmas_id;

            $rematriData = Sekolah::select('sekolah.sekolah as sekolah_nama', 'sekolah.id as sekolah_id', \DB::raw('COUNT(rematri_sekolah.id) as rematri_count'))
                ->leftJoin('rematri_sekolah', 'sekolah.id', '=', 'rematri_sekolah.sekolah_id')
                ->where('sekolah.puskesmas_id', $puskesmas_id)
                ->groupBy('sekolah.id', 'sekolah.sekolah')
                ->get();

            return view('admin.dashboard.puskesmas', compact('menu', 'sekolah_puskes', 'posyandu_puskes', 'usersekolah_puskes', 'userposyandu_puskes', 'bulan', 'rematriData'));
        } elseif ($auth == 3) {

            $bulan = Sesi::with('sesi_rematri')
                ->selectRaw("DATE_FORMAT(sesi.created_at, '%b') as nama_bulan, MONTH(sesi.created_at) as bulan")
                ->where('sekolah_id', '=', Auth::user()->sekolah_id)
                ->groupBy('nama_bulan', 'bulan')
                ->orderBy('bulan')
                ->get();
            return view('admin.dashboard.sekolah', compact('menu', 'bulan'));
        } else {
            return view('admin.dashboard.posyandu', compact('menu', 'rematri_count'));
        }
    }

    public function chartPuskesmas($month)
    {
        $sesi = DB::table('sesi')
            ->join('sesi_rematri', 'sesi.id', '=', 'sesi_rematri.sesi_id')
            ->join('sekolah', 'sesi.sekolah_id', '=', 'sekolah.id')
            ->selectRaw('sekolah.sekolah AS nama_sekolah, CONCAT(MONTHNAME(sesi.created_at), " Minggu ", WEEK(sesi.created_at) - WEEK(DATE_SUB(sesi.created_at, INTERVAL DAYOFMONTH(sesi.created_at) - 1 DAY))) as sesi_week, COUNT(*) as rematri_count, SUM(CASE WHEN sesi_rematri.foto IS NOT NULL THEN 1 ELSE 0 END) as ttd_count')
            ->whereRaw('MONTH(sesi.created_at) = ?', [$month])
            ->where('sesi.puskesmas_id', '=', Auth::user()->puskesmas_id) // Menentukan tabel 'sesi' untuk kolom 'puskesmas_id'
            ->groupBy('nama_sekolah', 'sesi_week')
            ->orderBy('nama_sekolah')
            ->orderBy('sesi_week')
            ->get();

        $result = [];

        foreach ($sesi as $data) {
            $weekNumber = intval(explode(' ', $data->sesi_week)[2]);
            $weekLabel = '';

            if ($weekNumber == 1) {
                $weekLabel = 'Pertama';
            } elseif ($weekNumber == 2) {
                $weekLabel = 'Kedua';
            } elseif ($weekNumber == 3) {
                $weekLabel = 'Ketiga';
            } elseif ($weekNumber == 4) {
                $weekLabel = 'Keempat';
            }

            $monthName = date('F', strtotime(explode(' ', $data->sesi_week)[0]));
            $data->sesi_week = $monthName . ' Minggu ' . $weekLabel;

            $result[] = [
                'nama_sekolah' => $data->nama_sekolah,
                'sesi_week' => $data->sesi_week,
                'rematri_count' => $data->rematri_count,
                'ttd_count' => $data->ttd_count
            ];
        }

        return response()->json($result);
    }

    public function chartSekolah($month)
    {
        $sesi = DB::table('sesi')
            ->join('sesi_rematri', 'sesi.id', '=', 'sesi_rematri.sesi_id')
            ->selectRaw('CONCAT(MONTHNAME(sesi.created_at), " Minggu ", WEEK(sesi.created_at) - WEEK(DATE_SUB(sesi.created_at, INTERVAL DAYOFMONTH(sesi.created_at) - 1 DAY))) as sesi_week, COUNT(*) as rematri_count, SUM(CASE WHEN sesi_rematri.foto IS NOT NULL THEN 1 ELSE 0 END) as ttd_count')
            ->whereRaw('MONTH(sesi.created_at) = ?', [$month])
            ->where('sekolah_id', '=', Auth::user()->sekolah_id)
            ->groupBy('sesi_week')
            ->orderBy('sesi_week')
            ->get();

        // Mengubah angka minggu menjadi format "Label" dan menambahkan nama bulan
        foreach ($sesi as $data) {
            $weekNumber = intval(explode(' ', $data->sesi_week)[2]);
            $weekLabel = '';

            if ($weekNumber == 1) {
                $weekLabel = 'Pertama';
            } elseif ($weekNumber == 2) {
                $weekLabel = 'Kedua';
            } elseif ($weekNumber == 3) {
                $weekLabel = 'Ketiga';
            } elseif ($weekNumber == 4) {
                $weekLabel = 'Keempat';
            }

            $monthName = date('F', strtotime(explode(' ', $data->sesi_week)[0]));
            $data->sesi_week = $monthName . ' Minggu ' . $weekLabel;
        }

        return response()->json($sesi);
    }

    // public function puskesmas(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Puskesmas::with('rematri')->get();
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('rematri', function ($data) {
    //                 return '<center>' . $data->rematri->count() . '</center>';
    //             })
    //             ->rawColumns(['rematri'])
    //             ->make(true);
    //     }
    // }
}
