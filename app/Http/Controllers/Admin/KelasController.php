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
        if ($request->ajax()) {
            $data = Kelas::where('sekolah_id', Auth::user()->sekolah_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.kelas.data', compact('menu'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nama.required' => 'Nama Kelas harus diisi.',
            'nama.unique' => 'Nama Kelas sudah ada.',
        );
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:kelas,nama',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Kelas::updateOrCreate(
            [
                'id' => $request->hidden_id
            ],
            [
                'sekolah_id' => Auth::user()->sekolah_id,
                'nama' => $request->nama,
            ]
        );
        return response()->json(['success' => 'Kelas saved successfully.']);
    }

    public function destroy($id)
    {
        Kelas::find($id)->delete();
        return response()->json(['success' => 'Kelas deleted successfully.']);
    }

    public function getKelas(Request $request)
    {
        $data = Kelas::where('sekolah_id', $request->sekolah_id)->get(["nama", "id"]);
        // $data = Kelas::with('jurusan')->where('jurusan_id', $request->jurusan_id)->get();
        return response()->json($data);
    }
}
