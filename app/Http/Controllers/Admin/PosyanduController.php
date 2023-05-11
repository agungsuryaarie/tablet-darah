<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Puskesmas;
use App\Models\Kecamatan;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class PosyanduController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Posyandu';
        $kecamatan = Kecamatan::get();
        if ($request->ajax()) {
            $data = Posyandu::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('posyandu', function ($data) {
                    return $data->posyandu;
                })
                ->addColumn('puskesmas', function ($data) {
                    return $data->puskesmas->puskesmas;
                })
                ->addColumn('desa', function ($data) {
                    return $data->desa->desa;
                })
                ->addColumn('kecamatan', function ($data) {
                    return $data->kecamatan->kecamatan;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editPos"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deletePos"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['posyandu', 'puskesmas', 'desa', 'kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.posyandu.data', compact('menu', 'kecamatan'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'desa_id.required' => 'Desa harus dipilih.',
            'puskesmas_id.required' => 'Puskesmas harus dipilih.',
            'nama_posyandu.required' => 'Nama Posyandu harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
            'puskesmas_id' => 'required',
            'nama_posyandu' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Posyandu::updateOrCreate(
            [
                'id' => $request->posyandu_id
            ],
            [
                'kecamatan_id' => $request->kecamatan_id,
                'desa_id' => $request->desa_id,
                'puskesmas_id' => $request->puskesmas_id,
                'posyandu' => $request->nama_posyandu,
            ]
        );
        return response()->json(['success' => 'Posyandu saved successfully.']);
    }

    public function edit($id)
    {
        $posyandu = Posyandu::find($id);
        return response()->json($posyandu);
    }

    public function destroy($id)
    {
        Posyandu::find($id)->delete();
        return response()->json(['success' => 'Posyandu deleted successfully.']);
    }
    public function getPuskes(Request $request)
    {
        $data['puskesmas'] = Puskesmas::where("kecamatan_id", $request->kecamatan_id)->get(["puskesmas", "id"]);
        return response()->json($data);
    }
    public function getDesa(Request $request)
    {
        $data['desa'] = Desa::where("kecamatan_id", $request->kecamatan_id)->get(["desa", "id"]);
        return response()->json($data);
    }
}
