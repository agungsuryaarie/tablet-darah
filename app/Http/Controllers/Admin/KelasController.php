<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Kelas';
        $jurusan = Jurusan::where('sekolah_id', Auth::user()->sekolah_id)->get();
        if ($request->ajax()) {
            $data = Kelas::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('jurusan', function ($data) {
                    return $data->jurusan->nama;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editKelas"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteKelas"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.kelas.data', compact('menu', 'jurusan'));
    }

    public function store(Request $request)
    {

        //Translate Bahasa Indonesia
        $message = array(
            'nama.required' => 'Nama Kelas harus diisi.',
            'jurusan_id.required' => 'Jurusan harus dipilih.',
        );
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jurusan_id' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Kelas::updateOrCreate(
            [
                'id' => $request->kelas_id
            ],
            [
                'nama' => $request->nama,
                'jurusan_id' => $request->jurusan_id,
                'ruangan' => $request->ruangan,
            ]
        );
        return response()->json(['success' => 'Desa saved successfully.']);
    }

    public function edit($id)
    {
        $kelas = Kelas::find($id);
        return response()->json($kelas);
    }

    public function destroy($id)
    {
        Kelas::find($id)->delete();
        return response()->json(['success' => 'Kelas deleted successfully.']);
    }
}
