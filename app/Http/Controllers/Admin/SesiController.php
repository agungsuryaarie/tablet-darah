<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rematri;
use App\Models\Sesi;
use App\Models\SesiRematri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class SesiController extends Controller
{
    public function index()
    {
        $menu = 'Sesi';
        $sesi = Sesi::where('sekolah_id', Auth::user()->sekolah_id)->latest()->get();
        foreach ($sesi as $s) {
            $kelas = $s->kelas_id;
        }
        $rematri = Rematri::where('kelas_id', $kelas)->count();
        return view('admin.sesi.data', compact('menu', 'sesi', 'rematri'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nama.required' => 'Nama Sesi harus diisi.',
            'jurusan_id.required' => 'Jurusan harus dipilih.',
            'kelas_id.required' => 'Kelas harus dipilih.',
        );
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jurusan_id' => 'required',
            'kelas_id' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        Sesi::updateOrCreate(
            [
                'id' => $request->sesi_id
            ],
            [
                'kecamatan_id' => Auth::user()->kecamatan_id,
                'puskesmas_id' => Auth::user()->puskesmas_id,
                'sekolah_id' => Auth::user()->sekolah_id,
                'nama' => $request->nama,
                'jurusan_id' => $request->jurusan_id,
                'kelas_id' => $request->kelas_id,
            ]
        );
        // $rematri = Rematri::where('kelas_id', $request->kelas_id)->first();
        $sesiid  = Sesi::orderBy('id', 'DESC')->first();
        SesiRematri::updateOrCreate(
            [
                'id' => $request->sesi_id
            ],
            [

                'sesi_id' => $sesiid->id,
                'kelas_id' => $sesiid->kelas_id,
            ]
        );

        return response()->json(['success' => 'Sesi saved successfully.']);
    }


    public function rematri(Request $request, $id)
    {
        $menu = 'Sesi';
        $sesi = Sesi::where('id', $id)->first();
        $kelas = $sesi->kelas_id;
        $rematri = Rematri::where('kelas_id', $kelas)->count();
        // $data = Sesi::with('rematri')->where('id', $id)->latest()->get();
        // dd($data);
        if ($request->ajax()) {
            $data = Rematri::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    return '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs absenRematri"><i class="fa fa-camera"></i></a></center>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.sesi.rematri', compact('menu', 'sesi', 'rematri'));
    }
    public function ttd($id)
    {
        $menu = 'Sesi TTD';
        return view('admin.sesi.ttd', compact('menu'));
    }
}
