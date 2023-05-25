<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rematri;
use App\Models\Sesi;
use App\Models\SesiRematri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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
        $rematri = Rematri::where('kelas_id', $request->kelas_id)->get();
        $sesiid  = Sesi::orderBy('id', 'DESC')->first();
        // fecth rematri
        foreach ($rematri as $r) {
            $id_rematri = $r->id;
            //simpan seluruh rematri dari kelas
            SesiRematri::create(
                [
                    'sesi_id' => $sesiid->id,
                    'kelas_id' => $sesiid->kelas_id,
                    'rematri_id' => $id_rematri,
                ]
            );
        }
        return response()->json(['success' => 'Sesi saved successfully.']);
    }


    public function rematri(Request $request, $id)
    {
        $menu = 'Sesi';
        $sesi = Sesi::where('id', Crypt::decryptString($id))->first();
        $count = Rematri::where('kelas_id', $sesi->kelas_id)->count();
        // $rematri = Rematri::where('kelas_id', $sesi->kelas_id)->first();
        // $data = Rematri::where('rematri.kelas_id', $sesi->kelas_id)
        //     // ->where('foto_sesi.sesi_id', $sesi->id)
        //     ->leftJoin('foto_sesi', 'rematri.id', '=', 'foto_sesi.rematri_id')
        //     ->select('rematri.*', 'foto_sesi.foto')
        //     ->get();
        // $data = SesiRematri::leftJoin('rematri', 'sesi_rematri.rematri_id', '=', 'rematri.id')
        //     ->where('sesi_rematri.kelas_id', $sesi->kelas_id)
        //     ->where('sesi_rematri.sesi_id', $sesi->id)
        //     ->select('rematri.*', 'sesi_rematri.*', 'sesi_rematri.id')
        //     ->first();
        // dd($data);
        if ($request->ajax()) {
            $data = SesiRematri::leftJoin('rematri', 'sesi_rematri.rematri_id', '=', 'rematri.id')
                ->where('sesi_rematri.kelas_id', $sesi->kelas_id)
                ->where('sesi_rematri.sesi_id', $sesi->id)
                ->select('rematri.*', 'sesi_rematri.*', 'sesi_rematri.id')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($data) {
                    return $data->nik;
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('foto', function ($data) {
                    if ($data->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-sesi/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><span class="text-danger"><i>* belum foto</i></span></center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    if ($row->foto == null) {
                        $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . Crypt::encryptString($row->rematri_id) . '" data-ttd="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs absenRematri"><i class="fa fa-camera"></i></a></center>';
                    } else {
                        $btn = '<center><span class="badge badge-success">selesai</span></center>';
                    }
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.sesi.rematri', compact('menu', 'sesi', 'count'));
    }
    public function ttd($id, $ids, $ttd)
    {
        $menu = 'Foto';
        $rematri = Rematri::where('id', Crypt::decryptString($ids))->first();
        $sesi = Sesi::where('id', $id)->first();
        $sesifoto = SesiRematri::find($ttd);
        return view('admin.sesi.ttd', compact('menu', 'rematri', 'sesi', 'sesifoto'));
    }
    public function upload(Request $request)
    {
        // dd($request->all());
        // $ttd = SesiRematri::find($request->ttd_id);
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

        SesiRematri::updateOrCreate(
            ['id' => $request->ttd_id],
            [
                'foto' => $img->hashName(),
            ]
        );
        //redirect to index
        return redirect()->route('sesi.rematri', Crypt::encryptString($request->sesi_id))->with(['status' => 'Foto uploaded successfully.']);
    }
    // fecth foto with ajax
    // ====================
    // public function foto($id)
    // {
    //     $foto = FotoSesi::where('rematri_id', $id)->first();
    //     return response()->json($foto);
    // }
}
