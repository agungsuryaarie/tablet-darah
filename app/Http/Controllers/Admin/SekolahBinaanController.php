<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use App\Models\Sekolah;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SekolahBinaanController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Sekolah Binaan';
        if ($request->ajax()) {
            $data = Sekolah::where('puskesmas_id', '=', Auth::user()->puskesmas_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editSekolahB"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSekolahB"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.sekolah-binaan.data', compact('menu'));
    }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
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
                'kecamatan_id' => Auth::user()->kecamatan_id,
                'puskesmas_id' => Auth::user()->puskesmas_id,
                'npsn' => $request->npsn,
                'sekolah' => $request->nama_sekolah,
                'jenjang' => $request->jenjang,
                'status' => $request->status,
                'alamat_jalan' => $request->alamat,
            ]
        );
        return response()->json(['success' => 'Sekolah Binaan saved successfully.']);
    }

    public function edit($id)
    {
        $sekolahb = Sekolah::find($id);
        return response()->json($sekolahb);
    }

    public function destroy($id)
    {
        Sekolah::find($id)->delete();
        return response()->json(['success' => 'Sekolah Binaan deleted successfully.']);
    }
}
