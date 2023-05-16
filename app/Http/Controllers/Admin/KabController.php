<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kabupaten;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class KabController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Kabupaten';
        if ($request->ajax()) {
            $data = Kabupaten::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode_wilayah', function ($data) {
                    return $data->kode_wilayah;
                })
                ->addColumn('kabupaten', function ($data) {
                    return $data->kabupaten;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editKab"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteKab"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kode_wilayah', 'kabupaten', 'action'])
                ->make(true);
        }

        return view('admin.kabupaten.data', compact('menu'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nama_kabupaten.required' => 'Nama Kabupaten harus diisi.',
            'kode_wilayah.required' => 'Kode Wilayah harus diisi.',
            'kode_wilayah.max' => 'Kode Wilayah maksimal 4 digit.',
            'kode_wilayah.min' => 'Kode Wilayah minimal 4 digit.',
        );
        $validator = Validator::make($request->all(), [
            'kode_wilayah' => 'required|max:4|min:4',
            'nama_kabupaten' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Kabupaten::updateOrCreate(
            [
                'id' => $request->kabupaten_id
            ],
            [
                'kode_wilayah' => $request->kode_wilayah,
                'kabupaten' => $request->nama_kabupaten,
            ]
        );
        return response()->json(['success' => 'Kabupaten saved successfully.']);
    }

    public function edit($id)
    {
        $kabupaten = Kabupaten::find($id);
        return response()->json($kabupaten);
    }

    public function getKabupaten()
    {
        $data = Kabupaten::get(["kabupaten", "id"]);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Kabupaten::find($id)->delete();
        return response()->json(['success' => 'Kabupaten deleted successfully.']);
    }
}
