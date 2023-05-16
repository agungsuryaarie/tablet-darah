<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PosyanduBinaanController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Posyandu Binaan';
        $kecamatan = Kecamatan::get();
        $desa = Desa::where('kecamatan_id', Auth::user()->kecamatan_id)->get();
        if ($request->ajax()) {
            $data = Posyandu::where('puskesmas_id', Auth::user()->puskesmas_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
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

        return view('admin.posyandu-binaan.data', compact('menu', 'kecamatan', 'desa'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'desa_id.required' => 'Desa harus dipilih.',
            'nama_posyandu.required' => 'Nama Posyandu harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'desa_id' => 'required',
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
                'kecamatan_id' => Auth::user()->kecamatan_id,
                'desa_id' => $request->desa_id,
                'puskesmas_id' => Auth::user()->puskesmas_id,
                'kode_posyandu' => $request->kode_posyandu,
                'posyandu' => $request->nama_posyandu,
            ]
        );
        return response()->json(['success' => 'Posyandu Binaan saved successfully.']);
    }

    public function edit($id)
    {
        $posyandub = Posyandu::find($id);
        return response()->json($posyandub);
    }

    public function destroy($id)
    {
        Posyandu::find($id)->delete();
        return response()->json(['success' => 'Posyandu Binaan deleted successfully.']);
    }
}
