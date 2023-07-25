<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Kelas';
        $auth = Auth::user();
        $kelas = Kelas::where('jenjang', $auth->jenjang)->latest()->get();
        $ruangan = Ruangan::where('sekolah_id', $auth->sekolah_id)->first();
        if ($request->ajax()) {
            $data = Ruangan::where('sekolah_id', $auth->sekolah_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kelas', function ($data) {
                    return $data->kelas->nama . ' - ' . $data->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i> Edit</a></center>';
                    // $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.ruangan.data', compact('menu', 'kelas', 'ruangan'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kelas_id.required' => 'Kelas harus dipilih.',
            'name.required' => 'Nama Ruangan harus diisi.',
            'name.unique' => 'Kombinasi kelas dan Ruangan sudah ada untuk sekolah ini.',
        );

        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required',
            'name' => 'required|unique:ruangan,name,NULL,id,kelas_id,' . $request->kelas_id . ',sekolah_id,' . Auth::user()->sekolah_id,
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        Ruangan::updateOrCreate(
            [
                'id' => $request->hidden_id
            ],
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'kelas_id' => $request->kelas_id,
                'name' => $request->name,
            ]
        );

        return response()->json(['success' => 'Ruangan saved successfully.']);
    }

    public function edit($id)
    {
        $data = Ruangan::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Ruangan::find($id)->delete();
        return response()->json(['success' => 'Ruangan deleted successfully.']);
    }

    public function show(Request $request)
    {
        $data = Ruangan::where("sekolah_id", Auth::user()->sekolah_id)->where("kelas_id", $request->kelas_id)->get(["nama", "id"]);
        return response()->json($data);
    }


    public function getRuangan(Request $request)
    {
        $data = Ruangan::where("sekolah_id", Auth::user()->sekolah_id)->where("kelas_id", $request->kelas_id)->get(["name", "id"]);
        return response()->json($data);
    }
    public function getRuanganSesi(Request $request)
    {
        $data = Ruangan::where("sekolah_id", Auth::user()->sekolah_id)->get(["name", "id"]);
        return response()->json($data);
    }
}
