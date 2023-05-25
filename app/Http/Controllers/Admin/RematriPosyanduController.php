<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\HbPosyandu;
use App\Models\Kecamatan;
use App\Models\Rematri;
use App\Models\RematriPosyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class RematriPosyanduController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Rematri';
        $kecamatan = Kecamatan::get();
        if ($request->ajax()) {
            $data = RematriPosyandu::where('posyandu_id', '=', Auth::user()->posyandu_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editRematri"><i class="fas fa-edit"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger mr-1 btn-xs deleteRematri"><i class="fas fa-trash"></i></a>';
                    $btn = '<center>' . $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . Crypt::encryptString($row->id) . '" data-original-title="History HB" class="btn btn-warning btn-xs text-white hbRematri"><i class="fas fa-plus-circle"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.rematri-posyandu.data', compact('menu'));
    }

    public function create()
    {
        $menu = 'Tambah Data Rematri';
        $kecamatan = Kecamatan::get();
        return view('admin.rematri-posyandu.create', compact('menu', 'kecamatan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'              => 'required|max:255',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required',
            'nokk'              => 'required|max:16|min:14',
            'nik'               => 'required|max:16|min:14|unique:rematri_posyandu,nik',
            'anak_ke'           => 'required|numeric',
            'email'             => 'required|email|unique:rematri_posyandu,email',
            'nohp'              => 'required|numeric',
            'agama'             => 'required',
            'berat_badan'       => 'required|numeric',
            'panjang_badan'     => 'required|numeric',
            'nama_ortu'         => 'required|max:255',
            'nik_ortu'          => 'required',
            'tlp_ortu'          => 'required|numeric',
            'kecamatan_id'      => 'required',
            'desa_id'           => 'required',
            'alamat'            => 'required|max:255',
        ], [
            'nama.required'             => 'Nama harus diisi.',
            'tempat_lahir.required'     => 'Tempat Lahir harus diisi.',
            'tgl_lahir.required'        => 'Tempat Lahir harus diisi.',
            'nokk.required'             => 'Nomor KK harus diisi.',
            'nokk.numeric'              => 'Nomor KK harus angka.',
            'nokk.max'                  => 'Nomor KK maksimal 16 digit.',
            'nokk.min'                  => 'Nomor KK minimal 16 digit.',
            'nik.required'              => 'NIK harus diisi.',
            'nik.numeric'               => 'NIK harus angka.',
            'nik.max'                   => 'NIK maksimal 16 digit.',
            'nik.min'                   => 'NIK minimal 16 digit.',
            'anak_ke.required'          => 'Anak Ke harus diisi.',
            'anak_ke.numeric'           => 'Anak Ke harus angka.',
            'email.required'            => 'Email harus diisi.',
            'email.email'               => 'Penulisan email tidak benar.',
            'email.unique'              => 'Email sudah terdaftar.',
            'nohp.required'              => 'Nomor Handphone harus diisi.',
            'nohp.numeric'               => 'Nomor Handphone harus angka.',
            'agama.required'            => 'Agama harus diisi.',
            'berat_badan.required'      => 'Berat Badan harus diisi.',
            'berat_badan.numeric'       => 'Berat Badan harus angka.',
            'panjang_badan.required'    => 'Panjang Badan harus diisi.',
            'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
            'nama_ortu'                 => 'Nama Orang Tua harus diisi.',
            'nik_ortu'                  => 'NIK Orang Tua harus diisi.',
            'tlp_ortu.required'         => 'Nomor Handphone Orang Tua harus diisi.',
            'tlp_ortu.numeric'          => 'Nomor Handphone Orang Tua harus angka.',
            'kecamatan_id'              => 'Kecamatan harus diisi.',
            'desa_id'                   => 'Desa harus diisi.',
            'alamat'                    => 'Alamat harus diisi.',
        ]);
        $validatedData['puskesmas_id'] = Auth::user()->puskesmas_id;
        $validatedData['posyandu_id'] = Auth::user()->posyandu_id;
        $rematri = RematriPosyandu::create($validatedData);

        return redirect()->route('rematri.posyandu.index')->with('success', json_encode(['success' => 'Rematri saved successfully.']));
    }

    public function edit($id)
    {
        $menu = 'Edit Data Rematri';
        $kecamatan = Kecamatan::get();
        $rematri = RematriPosyandu::find($id);
        return view('admin.rematri-posyandu.edit', compact('menu', 'kecamatan', 'rematri'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama'              => 'required|max:255',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required',
            'nokk'              => 'required|max:16|min:14',
            'nik'               => 'required|max:16|min:14',
            'anak_ke'           => 'required|numeric',
            'email'             => 'required|email',
            'nohp'              => 'required|numeric',
            'agama'             => 'required',
            'berat_badan'       => 'required|numeric',
            'panjang_badan'     => 'required|numeric',
            'nama_ortu'         => 'required|max:255',
            'nik_ortu'          => 'required',
            'tlp_ortu'          => 'required|numeric',
            'kecamatan_id'      => 'required',
            'desa_id'           => 'required',
            'alamat'            => 'required|max:255',
        ], [
            'nama.required'             => 'Nama harus diisi.',
            'tempat_lahir.required'     => 'Tempat Lahir harus diisi.',
            'tgl_lahir.required'        => 'Tempat Lahir harus diisi.',
            'nokk.required'             => 'Nomor KK harus diisi.',
            'nokk.numeric'              => 'Nomor KK harus angka.',
            'nokk.max'                  => 'Nomor KK maksimal 16 digit.',
            'nokk.min'                  => 'Nomor KK minimal 16 digit.',
            'nik.required'              => 'NIK harus diisi.',
            'nik.numeric'               => 'NIK harus angka.',
            'nik.max'                   => 'NIK maksimal 16 digit.',
            'nik.min'                   => 'NIK minimal 16 digit.',
            'anak_ke.required'          => 'Anak Ke harus diisi.',
            'anak_ke.numeric'           => 'Anak Ke harus angka.',
            'email.required'            => 'Email harus diisi.',
            'email.email'               => 'Penulisan email tidak benar.',
            'email.unique'              => 'Email sudah terdaftar.',
            'nohp.required'              => 'Nomor Handphone harus diisi.',
            'nohp.numeric'               => 'Nomor Handphone harus angka.',
            'agama.required'            => 'Agama harus diisi.',
            'berat_badan.required'      => 'Berat Badan harus diisi.',
            'berat_badan.numeric'       => 'Berat Badan harus angka.',
            'panjang_badan.required'    => 'Panjang Badan harus diisi.',
            'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
            'nama_ortu'                 => 'Nama Orang Tua harus diisi.',
            'nik_ortu'                  => 'NIK Orang Tua harus diisi.',
            'tlp_ortu.required'         => 'Nomor Handphone Orang Tua harus diisi.',
            'tlp_ortu.numeric'          => 'Nomor Handphone Orang Tua harus angka.',
            'kecamatan_id'              => 'Kecamatan harus diisi.',
            'desa_id'                   => 'Desa harus diisi.',
            'alamat'                    => 'Alamat harus diisi.',
        ]);
        $validatedData['puskesmas_id'] = Auth::user()->puskesmas_id;
        $validatedData['posyandu_id'] = Auth::user()->posyandu_id;
        $rematri = RematriPosyandu::find($id);
        $rematri->update($validatedData);

        return redirect()->route('rematri.posyandu.index')->with('success', json_encode(['success' => 'Rematri update successfully.']));
    }

    public function getDesa(Request $request)
    {
        $data['desa'] = Desa::where("kecamatan_id", $request->kecamatan_id)->get(["desa", "id"]);
        return response()->json($data);
    }

    public function destroy($id)
    {
        RematriPosyandu::find($id)->delete();
        return response()->json(['success' => 'Rematri deleted successfully.']);
    }
    public function hb(Request $request, $id)
    {
        $data = HbPosyandu::where('rematri_id', Crypt::decryptString($id))->get();
        $menu = 'Data HB Rematri';
        $rematri = RematriPosyandu::where('posyandu_id', Auth::user()->posyandu_id)->find(Crypt::decryptString($id));
        if ($request->ajax()) {
            $data = HbPosyandu::where('rematri_id', Crypt::decryptString($id))->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('berat_badan', function ($data) {
                    return '<center>' . $data->berat_badan . '<center>';
                })
                ->addColumn('panjang_badan', function ($data) {
                    return '<center>' . $data->panjang_badan . '<center>';
                })
                ->addColumn('hb', function ($data) {
                    return '<center>' . $data->hb . '<center>';
                })
                ->addColumn('action', function ($row) {
                    return '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteHB"><i class="fas fa-trash"></i></a><center>';
                })
                ->rawColumns(['berat_badan', 'panjang_badan', 'hb', 'action'])
                ->make(true);
        }

        return view('admin.rematri-posyandu.hb', compact('menu', 'rematri'));
    }
    public function storehb(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'tgl_cek.required'          => 'Tanggal Pengecekan harus diisi.',
            'berat_badan.required'      => 'Berat Badan harus diisi.',
            'berat_badan.numeric'       => 'Berat Badan harus angka.',
            'panjang_badan.required'    => 'Panjang Badan harus diisi.',
            'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
            'hb.required'               => 'HB harus diisi.',
            'hb.numeric'                => 'HB harus angka.',
        );
        $validator = Validator::make($request->all(), [
            'tgl_cek'         => 'required',
            'berat_badan'     => 'required|numeric',
            'panjang_badan'   => 'required|numeric',
            'hb'              => 'required|numeric',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        HbPosyandu::updateOrCreate(
            [
                'id' => $request->hb_id
            ],
            [
                'puskesmas_id' => Auth::user()->puskesmas_id,
                'posyandu_id' => Auth::user()->posyandu_id,
                'rematri_id' => $request->rematri_id,
                'tgl_cek' => $request->tgl_cek,
                'berat_badan' => $request->berat_badan,
                'panjang_badan' => $request->panjang_badan,
                'hb' => $request->hb,
            ]
        );
        return response()->json(['success' => 'HB saved successfully.']);
    }
    public function destroyhb($id)
    {
        HbPosyandu::find($id)->delete();
        return response()->json(['success' => 'HB deleted successfully.']);
    }
}
