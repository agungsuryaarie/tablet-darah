<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RematriPosyandu;
use App\Models\SesiPosyandu;
use App\Models\SesiRematriPosyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SesiPosyanduController extends Controller
{
    public function index()
    {
        $menu = 'Sesi Posyandu';
        $sesip = SesiPosyandu::where('posyandu_id', Auth::user()->posyandu_id)->latest()->get();
        return view('admin.sesi-posyandu.data', compact('menu', 'sesip'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nama.required' => 'Nama Sesi harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        SesiPosyandu::updateOrCreate(
            [
                'id' => $request->sesip_id
            ],
            [
                'puskesmas_id' => Auth::user()->puskesmas_id,
                'posyandu_id' => Auth::user()->posyandu_id,
                'nama' => $request->nama,
            ]
        );
        $rematrip = RematriPosyandu::get();
        $sesipid  = SesiPosyandu::orderBy('id', 'DESC')->first();
        // fecth rematri posyandu
        foreach ($rematrip as $rp) {
            $id_rematrip = $rp->id;
            //simpan seluruh rematri dari posyandu
            SesiRematriPosyandu::create(
                [
                    'sesi_posyandu_id' => $sesipid->id,
                    'posyandu_id' => $sesipid->posyandu_id,
                    'rematri_posyandu_id' => $id_rematrip,
                ]
            );
        }
        return response()->json(['success' => 'Sesi Posyandu saved successfully.']);
    }
    public function rematri(Request $request, $id)
    {
        $menu = 'Sesi Posyandu';
        $sesip = SesiPosyandu::where('id', Crypt::decryptString($id))->first();
        $count = RematriPosyandu::where('posyandu_id', $sesip->posyandu_id)->count();
        if ($request->ajax()) {
            $data = SesiRematriPosyandu::leftJoin('rematri_posyandu', 'sesi_rematri_posyandu.rematri_posyandu_id', '=', 'rematri_posyandu.id')
                ->where('sesi_rematri_posyandu.posyandu_id', $sesip->posyandu_id)
                ->where('sesi_rematri_posyandu.sesi_posyandu_id', $sesip->id)
                ->select('rematri_posyandu.*', 'sesi_rematri_posyandu.*', 'sesi_rematri_posyandu.id')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($data) {
                    return $data->nik;
                })
                ->addColumn('nama', function ($data) {
                    return $data->nama;
                })
                ->addColumn('foto', function ($data) {
                    if ($data->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-sesi-posyandu/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><span class="text-danger"><i>* belum foto</i></span></center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    if ($row->foto == null) {
                        $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . Crypt::encryptString($row->rematri_posyandu_id) . '" data-ttd="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs absenRematriP"><i class="fa fa-camera"></i></a></center>';
                    } else {
                        $btn = '<center><span class="badge badge-success">selesai</span></center>';
                    }
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.sesi-posyandu.rematri', compact('menu', 'sesip', 'count'));
    }
    public function ttd($id, $ids, $ttd)
    {
        $menu = 'Foto';
        $rematrip = RematriPosyandu::where('id', Crypt::decryptString($ids))->first();
        $sesip = SesiPosyandu::where('id', $id)->first();
        $sesipfoto = SesiRematriPosyandu::find($ttd);
        return view('admin.sesi-posyandu.ttd', compact('menu', 'rematrip', 'sesip', 'sesipfoto'));
    }
    public function upload(Request $request)
    {
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
        $img->storeAs('public/foto-sesi-posyandu/', $img->hashName());

        SesiRematriPosyandu::updateOrCreate(
            ['id' => $request->ttd_posyandu_id],
            [
                'foto' => $img->hashName(),
            ]
        );
        //redirect to index
        return redirect()->route('sesi.posyandu.rematri', Crypt::encryptString($request->sesip_id))->with(['status' => 'Foto uploaded successfully.']);
    }
}
