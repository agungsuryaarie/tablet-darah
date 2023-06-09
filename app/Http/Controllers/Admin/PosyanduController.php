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
            'kode_posyandu.required' => 'Kode Posyandu harus diisi.',
            'kode_posyandu.unique' => 'Kode Posyandu sudah terdaftar.',
            'nama_posyandu.required' => 'Nama Posyandu harus diisi.',
        );
        //Check If Field Unique
        if (!$request->posyandu_id) {
            //rule tambah data tanpa user_id
            $ruleKode = 'required|unique:posyandu,kode_posyandu';
        } else {
            //rule edit jika tidak ada user_id
            $lastKode = Posyandu::where('id', $request->posyandu_id)->first();
            if ($lastKode->kode_posyandu == $request->kode_posyandu) {
                $ruleKode = 'required';
            } else {
                $ruleKode = 'required|unique:posyandu,kode_posyandu';
            }
        }
        $validator = Validator::make($request->all(), [
            'kecamatan_id' => 'required',
            'desa_id' => 'required',
            'kode_posyandu' => $ruleKode,
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
                'kode_posyandu' => $request->kode_posyandu,
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

    public function getPosyandu(Request $request)
    {
        $data = Posyandu::where("puskesmas_id", $request->puskesmas_id)->get(["posyandu", "id"]);
        return response()->json($data);
    }
}
