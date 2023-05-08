<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class KecController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Kecamatan';
        $kabupaten = Kabupaten::get();
        if ($request->ajax()) {
            $data = Kecamatan::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode_wilayah', function ($data) {
                    return $data->kode_wilayah;
                })
                ->addColumn('kecamatan', function ($data) {
                    return $data->kecamatan;
                })
                ->addColumn('kabupaten', function ($data) {
                    return $data->kabupaten->kabupaten;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editKec"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteKec"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kode_wilayah', 'kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.kecamatan.data', compact('menu', 'kabupaten'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kabupaten_id.required' => 'Kabupaten harus dipilih.',
            'nama_kecamatan.required' => 'Nama Kecamatan harus diisi.',
            'kode_wilayah.required' => 'Kode Wilayah harus diisi.',
            'kode_wilayah.max' => 'Kode Wilayah maksimal 6 digit.',
            'kode_wilayah.min' => 'Kode Wilayah minimal 6 digit.',
        );
        $validator = Validator::make($request->all(), [
            'kabupaten_id' => 'required',
            'kode_wilayah' => 'required|max:6|min:6',
            'nama_kecamatan' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Kecamatan::updateOrCreate(
            [
                'id' => $request->kecamatan_id
            ],
            [
                'kabupaten_id' => $request->kabupaten_id,
                'kode_wilayah' => $request->kode_wilayah,
                'kecamatan' => $request->nama_kecamatan,
            ]
        );
        return response()->json(['success' => 'Kecamatan saved successfully.']);
    }

    public function edit($id)
    {
        $kecamatan = Kecamatan::find($id);
        return response()->json($kecamatan);
    }

    public function destroy($id)
    {
        Kecamatan::find($id)->delete();
        return response()->json(['success' => 'Kecamatan deleted successfully.']);
    }
}
