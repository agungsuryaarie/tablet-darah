<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class PuskesController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Puskesmas';
        $kecamatan = Kecamatan::get();
        if ($request->ajax()) {
            $data = Puskesmas::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('puskesmas', function ($data) {
                    return $data->puskesmas;
                })
                ->addColumn('kecamatan', function ($data) {
                    return $data->kecamatan->kecamatan;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editPuskes"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deletePuskes"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['puskesmas', 'kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.puskesmas.data', compact('menu', 'kecamatan'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'nama_puskesmas.required' => 'Nama Puskesmas harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'kecamatan_id' => 'required',
            'nama_puskesmas' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Puskesmas::updateOrCreate(
            [
                'id' => $request->puskesmas_id
            ],
            [
                'kecamatan_id' => $request->kecamatan_id,
                'puskesmas' => $request->nama_puskesmas,
            ]
        );
        return response()->json(['success' => 'Puskesmas saved successfully.']);
    }

    public function edit($id)
    {
        $puskesmas = Puskesmas::find($id);
        return response()->json($puskesmas);
    }

    public function destroy($id)
    {
        Puskesmas::find($id)->delete();
        return response()->json(['success' => 'Puskesmas deleted successfully.']);
    }
}
