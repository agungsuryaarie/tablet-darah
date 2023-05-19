<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FotoSesi;
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
        return view('admin.sesi.data', compact('menu', 'sesi'));
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
        $count = Rematri::where('kelas_id', $sesi->kelas_id)->count();
        $rematri = Rematri::where('kelas_id', $sesi->kelas_id)->first();
        // $data = Rematri::where('rematri.kelas_id', $sesi->kelas_id)
        //     ->leftJoin('foto_sesi', 'rematri.id', '=', 'foto_sesi.rematri_id')
        //     ->select('rematri.*', 'foto_sesi.foto')
        //     ->get();
        // dd($data);
        if ($request->ajax()) {
            $data = Rematri::where('rematri.kelas_id', $sesi->kelas_id)
                ->leftJoin('foto_sesi', 'rematri.id', '=', 'foto_sesi.rematri_id')
                ->select('rematri.*', 'foto_sesi.foto')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->foto == null) {
                        $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs absenRematri"><i class="fa fa-camera"></i></a></center>';
                    } else {
                        $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Lihat Foto" class="btn btn-success btn-xs fotoRematri"><i class="fa fa-images"></i> Lihat</a></center>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.sesi.rematri', compact('menu', 'sesi', 'rematri', 'count'));
    }
    public function ttd($id, $ids)
    {
        $menu = 'Foto';
        $rematri = Rematri::where('id', $ids)->first();
        $sesi = Sesi::where('id', $id)->first();
        return view('admin.sesi.ttd', compact('menu', 'rematri', 'sesi'));
    }
    public function upload(Request $request)
    {
        // dd($request->all());
        //Translate Bahasa Indonesia
        $message = array(
            'foto.images' => 'File harus image.',
            'foto.mimes' => 'Foto harus jpeg,png,jpg.',
            'foto,max' => 'File maksimal 3MB.',
        );
        $this->validate($request, [
            'foto' => 'image|mimes:jpeg,png,jpg|max:3000'
        ], $message);
        $img = $request->file('foto');
        $img->storeAs('public/foto-sesi/', $img->hashName());

        FotoSesi::create([
            'kecamatan_id' => Auth::user()->kecamatan_id,
            'puskesmas_id' => Auth::user()->puskesmas_id,
            'sekolah_id' => Auth::user()->sekolah_id,
            'kelas_id' => $request->kelas_id,
            'sesi_id' => $request->sesi_id,
            'rematri_id' => $request->rematri_id,
            'foto' => $img->hashName(),
        ]);
        //redirect to index
        return redirect()->route('sesi.rematri', $request->sesi_id)->with(['status' => 'Foto uploaded successfully.']);
    }
    public function foto($id)
    {
        $foto = FotoSesi::find($id);
        return response()->json($foto);
    }
}
