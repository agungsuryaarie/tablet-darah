<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Sekolah';
        $kabupaten = Kabupaten::get();
        if ($request->ajax()) {
            $data = Sekolah::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kabupaten', function ($data) {
                    return $data->kabupaten->kabupaten;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editSekolah"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSekolah"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.sekolah.data', compact('menu', 'kabupaten'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kabupaten_id.required' => 'Kabupaten harus dipilih.',
            'nama_sekolah.required' => 'Nama Sekolah harus diisi.',
            'npsn.required' => 'NPSN harus diisi.',
            'npsn.max' => 'NPSN maksimal 8 digit.',
            'npsn.min' => 'NPSN minimal 8 digit.',
            'jenjang.required' => 'Jenjang harus dipilih.',
            'status.required' => 'Status harus dipilih.',
        );
        $validator = Validator::make($request->all(), [
            'kabupaten_id' => 'required',
            'npsn' => 'required|max:8|min:8',
            'nama_sekolah' => 'required',
            'jenjang' => 'required',
            'status' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Sekolah::updateOrCreate(
            [
                'id' => $request->sekolah_id
            ],
            [
                'kabupaten_id' => $request->kabupaten_id,
                'npsn' => $request->npsn,
                'sekolah' => $request->nama_sekolah,
                'jenjang' => $request->jenjang,
                'status' => $request->status,
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
}
