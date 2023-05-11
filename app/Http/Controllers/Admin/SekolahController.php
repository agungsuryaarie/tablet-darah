<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Sekolah;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Sekolah';
        $kecamatan = Kecamatan::get();
        if ($request->ajax()) {
            $data = Sekolah::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kecamatan', function ($data) {
                    return $data->kecamatan->kecamatan;
                })
                ->addColumn('puskesmas', function ($data) {
                    return $data->puskesmas->puskesmas;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editSekolah"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSekolah"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.sekolah.data', compact('menu', 'kecamatan'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'puskesmas_id.required' => 'Puskesmas harus dipilih.',
            'nama_sekolah.required' => 'Nama Sekolah harus diisi.',
            'npsn.required' => 'NPSN harus diisi.',
            'npsn.max' => 'NPSN maksimal 8 digit.',
            'npsn.min' => 'NPSN minimal 8 digit.',
            'jenjang.required' => 'Jenjang harus dipilih.',
            'status.required' => 'Status harus dipilih.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat..max' => 'Alamat melebihi batas maksimal karakter.',
        );
        $validator = Validator::make($request->all(), [
            'kecamatan_id' => 'required',
            'puskesmas_id' => 'required',
            'npsn' => 'required|max:8|min:8',
            'nama_sekolah' => 'required',
            'jenjang' => 'required',
            'status' => 'required',
            'alamat' => 'required|max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Sekolah::updateOrCreate(
            [
                'id' => $request->sekolah_id
            ],
            [
                'kecamatan_id' => $request->kecamatan_id,
                'puskesmas_id' => $request->puskesmas_id,
                'npsn' => $request->npsn,
                'sekolah' => $request->nama_sekolah,
                'jenjang' => $request->jenjang,
                'status' => $request->status,
                'alamat_jalan' => $request->alamat,
            ]
        );
        return response()->json(['success' => 'Sekolah saved successfully.']);
    }

    public function edit($id)
    {
        $sekolah = Sekolah::find($id);
        return response()->json($sekolah);
    }

    public function destroy($id)
    {
        Sekolah::find($id)->delete();
        return response()->json(['success' => 'Sekolah deleted successfully.']);
    }
    public function getPuskes(Request $request)
    {
        $data['puskesmas'] = Puskesmas::where("kecamatan_id", $request->kecamatan_id)->get(["puskesmas", "id"]);
        return response()->json($data);
    }
}
