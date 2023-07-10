<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Jurusan';
        $kelas = Kelas::where('sekolah_id', Auth::user()->sekolah_id)->get();
        if ($request->ajax()) {
            $data = Jurusan::where('sekolah_id', Auth::user()->sekolah_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kelas', function ($data) {
                    return $data->kelas->nama;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.jurusan.data', compact('menu', 'kelas'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nama.required' => 'Nama Jurusan harus diisi.',
            'kelas_id.required' => 'Kelas harus dipilih.',
            'ruangan.required' => 'Ruangan harus diisi.',
        );
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kelas_id' => 'required',
            'ruangan' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Jurusan::updateOrCreate(
            [
                'id' => $request->hidden_id
            ],
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'kelas_id' => $request->kelas_id,
                'nama' => $request->nama,
                'ruangan' => $request->ruangan,
            ]
        );
        return response()->json(['success' => 'Jurusan saved successfully.']);
    }

    public function edit($id)
    {
        $jurusan = Jurusan::find($id);
        return response()->json($jurusan);
    }

    public function destroy($id)
    {
        Jurusan::find($id)->delete();
        return response()->json(['success' => 'Jurusan deleted successfully.']);
    }

    public function getJurusan(Request $request)
    {
        $data = Jurusan::with('kelas')->where('kelas_id', $request->kelas_id)->get();
        // $data = Jurusan::where('sekolah_id', $request->sekolah_id)->get(["nama", "id"]);
        return response()->json($data);
    }
}
