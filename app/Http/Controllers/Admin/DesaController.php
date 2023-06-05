<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DesaController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Desa/Kelurahan';
        $kecamatan = Kecamatan::get();
        if ($request->ajax()) {
            $data = Desa::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kode_wilayah', function ($data) {
                    return $data->kode_wilayah;
                })
                ->addColumn('desa', function ($data) {
                    return $data->desa;
                })
                ->addColumn('kecamatan', function ($data) {
                    return $data->kecamatan->kecamatan;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editDesa"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteDesa"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kode_wilayah', 'desa', 'action'])
                ->make(true);
        }

        return view('admin.desa.data', compact('menu', 'kecamatan'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'nama_desa.required' => 'Nama Desa harus diisi.',
            'kode_wilayah.required' => 'Kode Wilayah harus diisi.',
            'kode_wilayah.max' => 'Kode Wilayah maksimal 10 digit.',
            'kode_wilayah.min' => 'Kode Wilayah minimal 10 digit.',
        );
        $validator = Validator::make($request->all(), [
            'kecamatan_id' => 'required',
            'kode_wilayah' => 'required|max:10|min:10',
            'nama_desa' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Desa::updateOrCreate(
            [
                'id' => $request->desa_id
            ],
            [
                'kecamatan_id' => $request->kecamatan_id,
                'kode_wilayah' => $request->kode_wilayah,
                'desa' => $request->nama_desa,
            ]
        );
        return response()->json(['success' => 'Desa saved successfully.']);
    }

    public function edit($id)
    {
        $desa = Desa::find($id);
        return response()->json($desa);
    }

    public function destroy($id)
    {
        Desa::find($id)->delete();
        return response()->json(['success' => 'Desa deleted successfully.']);
    }

    public function getDesa(Request $request)
    {
        $data = Desa::where("kecamatan_id", $request->kecamatan_id)->get(["desa", "id"]);
        return response()->json($data);
    }
}
