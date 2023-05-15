<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rematri;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class RematriController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Rematri';
        $kecamatan = Kecamatan::get();
        if ($request->ajax()) {
            $data = Rematri::where('sekolah_id', '=', Auth::user()->sekolah_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kelas', function ($data) {
                    return $data->kelas->nama . ' ' . $data->jurusan->nama . ' ' . $data->kelas->ruangan;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editRematri"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteRematri"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.rematri-sekolah.data', compact('menu'));
    }

    public function create()
    {
        $menu = 'Tambah Data Rematri';
        $jurusan = Jurusan::where('sekolah_id', Auth::user()->sekolah_id)->get();
        $kecamatan = Kecamatan::get();
        return view('admin.rematri-sekolah.create', compact('menu', 'jurusan', 'kecamatan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'              => 'required|max:255',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required',
            'nokk'              => 'required|max:16|min:14',
            'nik'               => 'required|max:16|min:14|unique:rematri,nik',
            'anak_ke'           => 'required|numeric',
            'email'             => 'required|email|unique:rematri,email',
            'nohp'              => 'required|numeric',
            'agama'             => 'required',
            'jurusan_id'        => 'required',
            'kelas_id'          => 'required',
            'berat_badan'       => 'required|numeric',
            'panjang_badan'     => 'required|numeric',
            'hb'                => 'required|numeric',
            'nama_ortu'         => 'required|max:255',
            'nik_ortu'          => 'required',
            'tlp_ortu'          => 'required|numeric',
            'kecamatan_id'      => 'required',
            'desa_id'           => 'required',
            'alamat'            => 'required|max:255',
        ], [
            'nama.required'             => 'Nama harus diisi.',
            'tempat_lahir.required'     => 'Tempat Lahir harus diisi.',
            'tgl_lahir.required'        => 'Tempat Lahir harus diisi.',
            'nokk.required'             => 'Nomor KK harus diisi.',
            'nokk.numeric'              => 'Nomor KK harus angka.',
            'nokk.max'                  => 'Nomor KK maksimal 16 digit.',
            'nokk.min'                  => 'Nomor KK minimal 16 digit.',
            'nik.required'              => 'NIK harus diisi.',
            'nik.numeric'               => 'NIK harus angka.',
            'nik.max'                   => 'NIK maksimal 16 digit.',
            'nik.min'                   => 'NIK minimal 16 digit.',
            'anak_ke.required'          => 'Anak Ke harus diisi.',
            'anak_ke.numeric'           => 'Anak Ke harus angka.',
            'email.required'            => 'Email harus diisi.',
            'email.email'               => 'Penulisan email tidak benar.',
            'email.unique'              => 'Email sudah terdaftar.',
            'nohp.required'              => 'Nomor Handphone harus diisi.',
            'nohp.numeric'               => 'Nomor Handphone harus angka.',
            'agama.required'            => 'Agama harus diisi.',
            'jurusan_id.required'       => 'Jurusan harus diisi.',
            'kelas_id.required'         => 'Kelas harus diisi.',
            'berat_badan.required'      => 'Berat Badan harus diisi.',
            'berat_badan.numeric'       => 'Berat Badan harus angka.',
            'panjang_badan.required'    => 'Panjang Badan harus diisi.',
            'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
            'hb.required'               => 'HB harus diisi.',
            'hb.numeric'                => 'HB harus angka.',
            'nama_ortu'                 => 'Nama Orang Tua harus diisi.',
            'nik_ortu'                  => 'NIK Orang Tua harus diisi.',
            'tlp_ortu.required'         => 'Nomor Handphone Orang Tua harus diisi.',
            'tlp_ortu.numeric'          => 'Nomor Handphone Orang Tua harus angka.',
            'kecamatan_id'              => 'Kecamatan harus diisi.',
            'desa_id'                   => 'Desa harus diisi.',
            'alamat'                    => 'Alamat harus diisi.',
        ]);
        $validatedData['puskesmas_id'] = Auth::user()->puskesmas_id;
        $validatedData['sekolah_id'] = Auth::user()->sekolah_id;
        $rematri = Rematri::create($validatedData);

        return redirect()->route('rematri.index')->with('success', json_encode(['success' => 'Rematri saved successfully.']));
    }


    public function edit($id)
    {
        $menu = 'Edit Data Rematri';
        $jurusan = Jurusan::where('sekolah_id', Auth::user()->sekolah_id)->get();
        $kecamatan = Kecamatan::get();
        $rematri = Rematri::find($id);
        return view('admin.rematri-sekolah.edit', compact('menu', 'jurusan', 'kecamatan', 'rematri'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama'              => 'required|max:255',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required',
            'nokk'              => 'required|max:16|min:14',
            'nik'               => 'required|max:16|min:14',
            'anak_ke'           => 'required|numeric',
            'email'             => 'required|email',
            'nohp'              => 'required|numeric',
            'agama'             => 'required',
            'jurusan_id'        => 'required',
            'kelas_id'          => 'required',
            'berat_badan'       => 'required|numeric',
            'panjang_badan'     => 'required|numeric',
            'hb'                => 'required|numeric',
            'nama_ortu'         => 'required|max:255',
            'nik_ortu'          => 'required',
            'tlp_ortu'          => 'required|numeric',
            'kecamatan_id'      => 'required',
            'desa_id'           => 'required',
            'alamat'            => 'required|max:255',
        ], [
            'nama.required'             => 'Nama harus diisi.',
            'tempat_lahir.required'     => 'Tempat Lahir harus diisi.',
            'tgl_lahir.required'        => 'Tempat Lahir harus diisi.',
            'nokk.required'             => 'Nomor KK harus diisi.',
            'nokk.numeric'              => 'Nomor KK harus angka.',
            'nokk.max'                  => 'Nomor KK maksimal 16 digit.',
            'nokk.min'                  => 'Nomor KK minimal 16 digit.',
            'nik.required'              => 'NIK harus diisi.',
            'nik.numeric'               => 'NIK harus angka.',
            'nik.max'                   => 'NIK maksimal 16 digit.',
            'nik.min'                   => 'NIK minimal 16 digit.',
            'anak_ke.required'          => 'Anak Ke harus diisi.',
            'anak_ke.numeric'           => 'Anak Ke harus angka.',
            'email.required'            => 'Email harus diisi.',
            'email.email'               => 'Penulisan email tidak benar.',
            'email.unique'              => 'Email sudah terdaftar.',
            'nohp.required'              => 'Nomor Handphone harus diisi.',
            'nohp.numeric'               => 'Nomor Handphone harus angka.',
            'agama.required'            => 'Agama harus diisi.',
            'jurusan_id.required'       => 'Jurusan harus diisi.',
            'kelas_id.required'         => 'Kelas harus diisi.',
            'berat_badan.required'      => 'Berat Badan harus diisi.',
            'berat_badan.numeric'       => 'Berat Badan harus angka.',
            'panjang_badan.required'    => 'Panjang Badan harus diisi.',
            'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
            'hb.required'               => 'HB harus diisi.',
            'hb.numeric'                => 'HB harus angka.',
            'nama_ortu'                 => 'Nama Orang Tua harus diisi.',
            'nik_ortu'                  => 'NIK Orang Tua harus diisi.',
            'tlp_ortu.required'         => 'Nomor Handphone Orang Tua harus diisi.',
            'tlp_ortu.numeric'          => 'Nomor Handphone Orang Tua harus angka.',
            'kecamatan_id'              => 'Kecamatan harus diisi.',
            'desa_id'                   => 'Desa harus diisi.',
            'alamat'                    => 'Alamat harus diisi.',
        ]);
        $validatedData['puskesmas_id'] = Auth::user()->puskesmas_id;
        $validatedData['sekolah_id'] = Auth::user()->sekolah_id;
        $rematri = Rematri::find($id);
        $rematri->update($validatedData);

        return redirect()->route('rematri.index')->with('success', json_encode(['success' => 'Rematri update successfully.']));
    }

    public function getKelas(Request $request)
    {
        $data['kelas'] = Kelas::with('jurusan')->where("jurusan_id", $request->jurusan_id)
            ->get();

        return response()->json($data);
    }

    public function getDesa(Request $request)
    {
        $data['desa'] = Desa::where("kecamatan_id", $request->kecamatan_id)->get(["desa", "id"]);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Rematri::find($id)->delete();
        return response()->json(['success' => 'Rematri deleted successfully.']);
    }
}
