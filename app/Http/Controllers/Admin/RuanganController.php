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
        $menu = 'Ruangan';
        $auth = Auth::user();
        $kelas = Kelas::where('jenjang', $auth->jenjang)->get();
        if ($request->ajax()) {
            $data = Ruangan::where('sekolah_id', $auth->sekolah_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kelas', function ($data) {
                    return $data->kelas->nama;
                })
                ->make(true);
        }

        return view('admin.ruangan.data', compact('menu', 'kelas'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kelas_id.required' => 'Kelas harus dipilih.',
            'nama.required' => 'Nama Ruangan harus diisi.',
        );

        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required',
            'nama' => 'required',
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
                'nama' => $request->nama,
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
        $data = Ruangan::where("sekolah_id", Auth::user()->sekolah_id)->where("kelas_id", $request->kelas_id)->get(["nama", "id"]);
        return response()->json($data);
    }
}
