<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rematri;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\HB;
use App\Models\HbPosyandu;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\RematriPosyandu;
use App\Models\RematriSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\Datatables\Datatables;

class RematriController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Rematri';
        $kecamatan = Kecamatan::get();
        $data = RematriSekolah::where('sekolah_id', '=', Auth::user()->sekolah_id)->get();
        // dd($data);
        if (Auth::user()->sekolah_id) {
            if ($request->ajax()) {
                $data = RematriSekolah::where('sekolah_id', '=', Auth::user()->sekolah_id)->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nik', function ($data) {
                        return $data->rematri->nik;
                    })
                    ->addColumn('nama', function ($data) {
                        return $data->rematri->nama;
                    })
                    ->addColumn('tgl_lahir', function ($data) {
                        return $data->rematri->tgl_lahir;
                    })
                    ->addColumn('nama_ortu', function ($data) {
                        return $data->rematri->nama_ortu;
                    })
                    ->addColumn('kelas', function ($data) {
                        if ($data->jurusan_id == null) {
                            $kelas =  $data->kelas->nama;
                        } else {
                            $kelas =  $data->kelas->nama . ' ' . $data->jurusan->nama . ' ' . $data->jurusan->ruangan;
                        }
                        return $kelas;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . Crypt::encryptString($row->rematri_id) . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editRematri"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->rematri_id . '" data-original-title="Delete" class="btn btn-danger btn-xs mr-1 deleteRematri"><i class="fas fa-trash"></i></a>';
                        $btn = '<center>' . $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . Crypt::encryptString($row->id) . '" data-original-title="History HB" class="btn btn-warning btn-xs text-white hbRematri"><i class="fas fa-plus-circle"></i></a><center>';
                        return $btn;
                    })
                    ->rawColumns(['kecamatan', 'action'])
                    ->make(true);
            }
            return view('admin.rematri-sekolah.data', compact('menu'));
        } else {
            if ($request->ajax()) {
                $data = RematriPosyandu::where('posyandu_id', '=', Auth::user()->posyandu_id)->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nik', function ($data) {
                        return $data->rematri->nik;
                    })
                    ->addColumn('nama', function ($data) {
                        return $data->rematri->nama;
                    })
                    ->addColumn('tgl_lahir', function ($data) {
                        return $data->rematri->tgl_lahir;
                    })
                    ->addColumn('nama_ortu', function ($data) {
                        return $data->rematri->nama_ortu;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . Crypt::encryptString($row->rematri_id) . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editRematri"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->rematri_id . '" data-original-title="Delete" class="btn btn-danger mr-1 btn-xs deleteRematri"><i class="fas fa-trash"></i></a>';
                        $btn = '<center>' . $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . Crypt::encryptString($row->id) . '" data-original-title="History HB" class="btn btn-warning btn-xs text-white hbRematri"><i class="fas fa-plus-circle"></i></a><center>';
                        return $btn;
                    })
                    ->rawColumns(['kecamatan', 'action'])
                    ->make(true);
            }
            return view('admin.rematri-posyandu.data', compact('menu'));
        }
    }

    public function create()
    {
        $menu = 'Tambah Data Rematri';
        if (Auth::user()->sekolah_id) {
            $kelas = Kelas::where('sekolah_id', Auth::user()->sekolah_id)->get();
            $kecamatan = Kecamatan::get();
            return view('admin.rematri-sekolah.create', compact('menu', 'kelas', 'kecamatan'));
        } else {
            $kecamatan = Kecamatan::get();
            return view('admin.rematri-posyandu.create', compact('menu', 'kecamatan'));
        }
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        if (Auth::user()->sekolah_id) {
            $message = array(
                'nama.required'             => 'Nama harus diisi.',
                'tempat_lahir.required'     => 'Tempat Lahir harus diisi.',
                'tgl_lahir.required'        => 'Tanggal Lahir harus diisi.',
                'nokk.required'             => 'Nomor KK harus diisi.',
                'nokk.numeric'              => 'Nomor KK harus angka.',
                'nokk.max'                  => 'Nomor KK maksimal 16 digit.',
                'nokk.min'                  => 'Nomor KK minimal 16 digit.',
                'nik.required'              => 'NIK harus diisi.',
                'nik.numeric'               => 'NIK harus angka.',
                'nik.max'                   => 'NIK maksimal 16 digit.',
                'nik.min'                   => 'NIK minimal 16 digit.',
                'nik.unique'                => 'NIK sudah terdaftar.',
                'anak_ke.required'          => 'Anak Ke harus diisi.',
                'anak_ke.numeric'           => 'Anak Ke harus angka.',
                'email.required'            => 'Email harus diisi.',
                'email.email'               => 'Penulisan email tidak benar.',
                'email.unique'              => 'Email sudah terdaftar.',
                'nohp.required'             => 'Nomor Handphone harus diisi.',
                'nohp.numeric'              => 'Nomor Handphone harus angka.',
                'agama.required'            => 'Agama harus diisi.',
                'kelas_id.required'         => 'Kelas harus diisi.',
                'berat_badan.required'      => 'Berat Badan harus diisi.',
                'berat_badan.numeric'       => 'Berat Badan harus angka.',
                'panjang_badan.required'    => 'Panjang Badan harus diisi.',
                'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
                'nama_ortu'                 => 'Nama Orang Tua harus diisi.',
                'nik_ortu'                  => 'NIK Orang Tua harus diisi.',
                'nik_ortu.max'              => 'NIK Orang Tua maksimal 16 digit.',
                'nik_ortu.min'              => 'NIK Orang Tua minimal 16 digit.',
                'nik_ortu.unique'           => 'NIK Ortu sudah terdaftar.',
                'tlp_ortu.required'         => 'Nomor Handphone Orang Tua harus diisi.',
                'tlp_ortu.numeric'          => 'Nomor Handphone Orang Tua harus angka.',
                'kecamatan_id'              => 'Kecamatan harus dipilih.',
                'desa_id'                   => 'Desa harus dipilih.',
                'alamat'                    => 'Alamat harus diisi.',
            );
        } else {
            $message = array(
                'nama.required'             => 'Nama harus diisi.',
                'tempat_lahir.required'     => 'Tempat Lahir harus diisi.',
                'tgl_lahir.required'        => 'Tanggal Lahir harus diisi.',
                'nokk.required'             => 'Nomor KK harus diisi.',
                'nokk.numeric'              => 'Nomor KK harus angka.',
                'nokk.max'                  => 'Nomor KK maksimal 16 digit.',
                'nokk.min'                  => 'Nomor KK minimal 16 digit.',
                'nik.required'              => 'NIK harus diisi.',
                'nik.numeric'               => 'NIK harus angka.',
                'nik.max'                   => 'NIK maksimal 16 digit.',
                'nik.min'                   => 'NIK minimal 16 digit.',
                'nik.unique'                => 'NIK sudah terdaftar.',
                'anak_ke.required'          => 'Anak Ke harus diisi.',
                'anak_ke.numeric'           => 'Anak Ke harus angka.',
                'email.required'            => 'Email harus diisi.',
                'email.email'               => 'Penulisan email tidak benar.',
                'email.unique'              => 'Email sudah terdaftar.',
                'nohp.required'             => 'Nomor Handphone harus diisi.',
                'nohp.numeric'              => 'Nomor Handphone harus angka.',
                'agama.required'            => 'Agama harus diisi.',
                'berat_badan.required'      => 'Berat Badan harus diisi.',
                'berat_badan.numeric'       => 'Berat Badan harus angka.',
                'panjang_badan.required'    => 'Panjang Badan harus diisi.',
                'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
                'nama_ortu'                 => 'Nama Orang Tua harus diisi.',
                'nik_ortu'                  => 'NIK Orang Tua harus diisi.',
                'nik_ortu.max'              => 'NIK Orang Tua maksimal 16 digit.',
                'nik_ortu.min'              => 'NIK Orang Tua minimal 16 digit.',
                'nik_ortu.unique'           => 'NIK Ortu sudah terdaftar.',
                'tlp_ortu.required'         => 'Nomor Handphone Orang Tua harus diisi.',
                'tlp_ortu.numeric'          => 'Nomor Handphone Orang Tua harus angka.',
                'kecamatan_id'              => 'Kecamatan harus dipilih.',
                'desa_id'                   => 'Desa harus dipilih.',
                'alamat'                    => 'Alamat harus diisi.',
            );
        }
        if (Auth::user()->sekolah_id) {
            $validator = Validator::make($request->all(), [
                'nama'              => 'required|max:255',
                'tempat_lahir'      => 'required',
                'tgl_lahir'         => 'required',
                'nokk'              => 'required|max:16|min:16',
                'nik'               => 'required|max:16|min:16|unique:rematri,nik',
                'anak_ke'           => 'required|numeric',
                'email'             => 'required|email|unique:rematri,email',
                'nohp'              => 'required|numeric',
                'agama'             => 'required',
                'kelas_id'          => 'required',
                'berat_badan'       => 'required|numeric',
                'panjang_badan'     => 'required|numeric',
                'nama_ortu'         => 'required|max:255',
                'nik_ortu'          => 'required||max:16|min:16|unique:rematri,nik_ortu',
                'tlp_ortu'          => 'required|numeric',
                'kecamatan_id'      => 'required',
                'desa_id'           => 'required',
                'alamat'            => 'required|max:255',
            ], $message);
        } else {
            $validator = Validator::make($request->all(), [
                'nama'              => 'required|max:255',
                'tempat_lahir'      => 'required',
                'tgl_lahir'         => 'required',
                'nokk'              => 'required|max:16|min:16',
                'nik'               => 'required|max:16|min:16|unique:rematri,nik',
                'anak_ke'           => 'required|numeric',
                'email'             => 'required|email|unique:rematri,email',
                'nohp'              => 'required|numeric',
                'agama'             => 'required',
                'berat_badan'       => 'required|numeric',
                'panjang_badan'     => 'required|numeric',
                'nama_ortu'         => 'required|max:255',
                'nik_ortu'          => 'required||max:16|min:16|unique:rematri,nik_ortu',
                'tlp_ortu'          => 'required|numeric',
                'kecamatan_id'      => 'required',
                'desa_id'           => 'required',
                'alamat'            => 'required|max:255',
            ], $message);
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $rematri = Rematri::create([
            'nama'              => $request->nama,
            'tempat_lahir'      => $request->tempat_lahir,
            'tgl_lahir'         => $request->tgl_lahir,
            'nokk'              => $request->nokk,
            'nik'               => $request->nik,
            'anak_ke'           => $request->anak_ke,
            'email'             => $request->email,
            'nohp'              => $request->nohp,
            'agama'             => $request->agama,
            'berat_badan'       => $request->berat_badan,
            'panjang_badan'     => $request->panjang_badan,
            'nama_ortu'         => $request->nama_ortu,
            'nik_ortu'          => $request->nik_ortu,
            'tlp_ortu'          => $request->tlp_ortu,
            'kecamatan_id'      => $request->kecamatan_id,
            'desa_id'           => $request->desa_id,
            'alamat'            => $request->alamat,
        ]);
        if (Auth::user()->sekolah_id) {
            $sekolah = new RematriSekolah;
            $sekolah->rematri_id = $rematri->id;
            $sekolah->puskesmas_id = Auth::user()->puskesmas_id;
            $sekolah->sekolah_id = Auth::user()->sekolah_id;
            $sekolah->kelas_id = $request->kelas_id;
            $sekolah->jurusan_id = $request->jurusan_id;
            $sekolah->save();
            return redirect()->route('rematri.index')->with('toast_success', 'Rematri saved successfully.');
        } else {
            $posyandu = new RematriPosyandu();
            $posyandu->rematri_id = $rematri->id;
            $posyandu->puskesmas_id = Auth::user()->puskesmas_id;
            $posyandu->posyandu_id = Auth::user()->posyandu_id;
            $posyandu->save();
            return redirect()->route('rematri.posyandu.index')->with('toast_success', 'Rematri saved successfully.');
        }
    }

    public function edit($id)
    {
        if (Auth::user()->sekolah_id) {
            $menu = 'Edit Data Rematri';
            $kelas = Kelas::where('sekolah_id', Auth::user()->sekolah_id)->get();
            $kecamatan = Kecamatan::get();
            $data = RematriSekolah::where('rematri_id', Crypt::decryptString($id))->first();
            return view('admin.rematri-sekolah.edit', compact('menu', 'kelas', 'kecamatan', 'data'));
        } else {
            $menu = 'Edit Data Rematri';
            $kecamatan = Kecamatan::get();
            $data = RematriPosyandu::where('rematri_id', Crypt::decryptString($id))->first();
            return view('admin.rematri-posyandu.edit', compact('menu', 'kecamatan', 'data'));
        }
    }

    public function update(Request $request, $id)
    {
        $rematri = Rematri::find($id);
        //Translate Bahasa Indonesia
        if (Auth::user()->sekolah_id) {
            $message = array(
                'nama.required'             => 'Nama harus diisi.',
                'tempat_lahir.required'     => 'Tempat Lahir harus diisi.',
                'tgl_lahir.required'        => 'Tanggal Lahir harus diisi.',
                'nokk.required'             => 'Nomor KK harus diisi.',
                'nokk.numeric'              => 'Nomor KK harus angka.',
                'nokk.max'                  => 'Nomor KK maksimal 16 digit.',
                'nokk.min'                  => 'Nomor KK minimal 16 digit.',
                'nik.required'              => 'NIK harus diisi.',
                'nik.numeric'               => 'NIK harus angka.',
                'nik.max'                   => 'NIK maksimal 16 digit.',
                'nik.min'                   => 'NIK minimal 16 digit.',
                'nik.unique'                => 'NIK sudah terdaftar.',
                'anak_ke.required'          => 'Anak Ke harus diisi.',
                'anak_ke.numeric'           => 'Anak Ke harus angka.',
                'email.required'            => 'Email harus diisi.',
                'email.email'               => 'Penulisan email tidak benar.',
                'email.unique'              => 'Email sudah terdaftar.',
                'nohp.required'             => 'Nomor Handphone harus diisi.',
                'nohp.numeric'              => 'Nomor Handphone harus angka.',
                'agama.required'            => 'Agama harus diisi.',
                'kelas_id.required'         => 'Kelas harus diisi.',
                'berat_badan.required'      => 'Berat Badan harus diisi.',
                'berat_badan.numeric'       => 'Berat Badan harus angka.',
                'panjang_badan.required'    => 'Panjang Badan harus diisi.',
                'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
                'nama_ortu'                 => 'Nama Orang Tua harus diisi.',
                'nik_ortu'                  => 'NIK Orang Tua harus diisi.',
                'nik_ortu.max'              => 'NIK Orang Tua maksimal 16 digit.',
                'nik_ortu.min'              => 'NIK Orang Tua minimal 16 digit.',
                'nik_ortu.unique'           => 'NIK Ortu sudah terdaftar.',
                'tlp_ortu.required'         => 'Nomor Handphone Orang Tua harus diisi.',
                'tlp_ortu.numeric'          => 'Nomor Handphone Orang Tua harus angka.',
                'kecamatan_id'              => 'Kecamatan harus dipilih.',
                'desa_id'                   => 'Desa harus dipilih.',
                'alamat'                    => 'Alamat harus diisi.',
            );
        } else {
            $message = array(
                'nama.required'             => 'Nama harus diisi.',
                'tempat_lahir.required'     => 'Tempat Lahir harus diisi.',
                'tgl_lahir.required'        => 'Tanggal Lahir harus diisi.',
                'nokk.required'             => 'Nomor KK harus diisi.',
                'nokk.numeric'              => 'Nomor KK harus angka.',
                'nokk.max'                  => 'Nomor KK maksimal 16 digit.',
                'nokk.min'                  => 'Nomor KK minimal 16 digit.',
                'nik.required'              => 'NIK harus diisi.',
                'nik.numeric'               => 'NIK harus angka.',
                'nik.max'                   => 'NIK maksimal 16 digit.',
                'nik.min'                   => 'NIK minimal 16 digit.',
                'nik.unique'                => 'NIK sudah terdaftar.',
                'anak_ke.required'          => 'Anak Ke harus diisi.',
                'anak_ke.numeric'           => 'Anak Ke harus angka.',
                'email.required'            => 'Email harus diisi.',
                'email.email'               => 'Penulisan email tidak benar.',
                'email.unique'              => 'Email sudah terdaftar.',
                'nohp.required'             => 'Nomor Handphone harus diisi.',
                'nohp.numeric'              => 'Nomor Handphone harus angka.',
                'agama.required'            => 'Agama harus diisi.',
                'berat_badan.required'      => 'Berat Badan harus diisi.',
                'berat_badan.numeric'       => 'Berat Badan harus angka.',
                'panjang_badan.required'    => 'Panjang Badan harus diisi.',
                'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
                'nama_ortu'                 => 'Nama Orang Tua harus diisi.',
                'nik_ortu'                  => 'NIK Orang Tua harus diisi.',
                'nik_ortu.max'              => 'NIK Orang Tua maksimal 16 digit.',
                'nik_ortu.min'              => 'NIK Orang Tua minimal 16 digit.',
                'nik_ortu.unique'           => 'NIK Ortu sudah terdaftar.',
                'tlp_ortu.required'         => 'Nomor Handphone Orang Tua harus diisi.',
                'tlp_ortu.numeric'          => 'Nomor Handphone Orang Tua harus angka.',
                'kecamatan_id'              => 'Kecamatan harus dipilih.',
                'desa_id'                   => 'Desa harus dipilih.',
                'alamat'                    => 'Alamat harus diisi.',
            );
        }
        if ($rematri->nik == $request->nik) {
            $ruleNik = 'required|min:16|max:16';
        } else {
            $ruleNik = 'required|max:16|min:16|unique:rematri,nik';
        }
        if ($rematri->nik_ortu == $request->nik_ortu) {
            $ruleNikO = 'required|min:16|max:16';
        } else {
            $ruleNikO = 'required|max:16|min:16|unique:rematri,nik_ortu';
        }
        if ($rematri->email == $request->email) {
            $ruleEmail = 'required|email';
        } else {
            $ruleEmail = 'required|email|unique:rematri,email';
        }
        if (Auth::user()->sekolah_id) {
            $validator = Validator::make($request->all(), [
                'nama'              => 'required|max:255',
                'tempat_lahir'      => 'required',
                'tgl_lahir'         => 'required',
                'nokk'              => 'required|max:16|min:16',
                'nik'               => $ruleNik,
                'anak_ke'           => 'required|numeric',
                'email'             => $ruleEmail,
                'nohp'              => 'required|numeric',
                'agama'             => 'required',
                'kelas_id'          => 'required',
                'berat_badan'       => 'required|numeric',
                'panjang_badan'     => 'required|numeric',
                'nama_ortu'         => 'required|max:255',
                'nik_ortu'          => $ruleNikO,
                'tlp_ortu'          => 'required|numeric',
                'kecamatan_id'      => 'required',
                'desa_id'           => 'required',
                'alamat'            => 'required|max:255',
            ], $message);
        } else {
            $validator = Validator::make($request->all(), [
                'nama'              => 'required|max:255',
                'tempat_lahir'      => 'required',
                'tgl_lahir'         => 'required',
                'nokk'              => 'required|max:16|min:16',
                'nik'               => $ruleNik,
                'anak_ke'           => 'required|numeric',
                'email'             => $ruleEmail,
                'nohp'              => 'required|numeric',
                'agama'             => 'required',
                'berat_badan'       => 'required|numeric',
                'panjang_badan'     => 'required|numeric',
                'nama_ortu'         => 'required|max:255',
                'nik_ortu'          => $ruleNikO,
                'tlp_ortu'          => 'required|numeric',
                'kecamatan_id'      => 'required',
                'desa_id'           => 'required',
                'alamat'            => 'required|max:255',
            ], $message);
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $rematri->update([
            'nama'              => $request->nama,
            'tempat_lahir'      => $request->tempat_lahir,
            'tgl_lahir'         => $request->tgl_lahir,
            'nokk'              => $request->nokk,
            'nik'               => $request->nik,
            'anak_ke'           => $request->anak_ke,
            'email'             => $request->email,
            'nohp'              => $request->nohp,
            'agama'             => $request->agama,
            'berat_badan'       => $request->berat_badan,
            'panjang_badan'     => $request->panjang_badan,
            'nama_ortu'         => $request->nama_ortu,
            'nik_ortu'          => $request->nik_ortu,
            'tlp_ortu'          => $request->tlp_ortu,
            'kecamatan_id'      => $request->kecamatan_id,
            'desa_id'           => $request->desa_id,
            'alamat'            => $request->alamat,
        ]);

        if (Auth::user()->sekolah_id) {
            $sekolah = RematriSekolah::where('rematri_id', $rematri->id)->first();
            $sekolah->sekolah_id = Auth::user()->sekolah_id;
            $sekolah->kelas_id = $request->kelas_id;
            $sekolah->jurusan_id = $request->jurusan_id;
            $sekolah->save();
            return redirect()->route('rematri.index')->with('toast_success', 'Rematri updated successfully.');
        } else {
            $sekolah = RematriPosyandu::where('rematri_id', $rematri->id)->first();
            $sekolah->puskesmas_id = Auth::user()->puskesmas_id;
            $sekolah->posyandu_id = Auth::user()->posyandu_id;
            $sekolah->save();
        }
        return redirect()->route('rematri.posyandu.index')->with('toast_success', 'Rematri updated successfully.');
    }

    public function getJurusan(Request $request)
    {
        $data['jurusan'] = Jurusan::with('kelas')->where("kelas_id", $request->kelas_id)
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
    public function hb(Request $request, $id)
    {
        $menu = 'Data HB Rematri';
        $data = RematriSekolah::where('sekolah_id', Auth::user()->sekolah_id)->find(Crypt::decryptString($id));
        // dd($data);
        if (Auth::user()->sekolah_id) {
            $data = RematriSekolah::where('sekolah_id', Auth::user()->sekolah_id)->find(Crypt::decryptString($id));
            if ($request->ajax()) {
                $data = HB::where('rematri_id', Crypt::decryptString($id))->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('berat_badan', function ($data) {
                        return '<center>' . $data->berat_badan . '<center>';
                    })
                    ->addColumn('panjang_badan', function ($data) {
                        return '<center>' . $data->panjang_badan . '<center>';
                    })
                    ->addColumn('hb', function ($data) {
                        return '<center>' . $data->hb . '<center>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteHB"><i class="fas fa-trash"></i></a><center>';
                    })
                    ->rawColumns(['berat_badan', 'panjang_badan', 'hb', 'action'])
                    ->make(true);
            }

            return view('admin.rematri-sekolah.hb', compact('menu', 'data'));
        } else {
            $data = RematriPosyandu::where('posyandu_id', Auth::user()->posyandu_id)->find(Crypt::decryptString($id));
            // dd($data);
            if ($request->ajax()) {
                $data = HbPosyandu::where('rematri_id', Crypt::decryptString($id))->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('berat_badan', function ($data) {
                        return '<center>' . $data->berat_badan . '<center>';
                    })
                    ->addColumn('panjang_badan', function ($data) {
                        return '<center>' . $data->panjang_badan . '<center>';
                    })
                    ->addColumn('hb', function ($data) {
                        return '<center>' . $data->hb . '<center>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteHB"><i class="fas fa-trash"></i></a><center>';
                    })
                    ->rawColumns(['berat_badan', 'panjang_badan', 'hb', 'action'])
                    ->make(true);
            }

            return view('admin.rematri-posyandu.hb', compact('menu', 'data'));
        }
    }
    public function storehb(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'tgl_cek.required'          => 'Tanggal Pengecekan harus diisi.',
            'berat_badan.required'      => 'Berat Badan harus diisi.',
            'berat_badan.numeric'       => 'Berat Badan harus angka.',
            'panjang_badan.required'    => 'Panjang Badan harus diisi.',
            'panjang_badan.numeric'     => 'Panjang Badan harus angka.',
            'hb.required'               => 'HB harus diisi.',
            'hb.numeric'                => 'HB harus angka.',
        );
        $validator = Validator::make($request->all(), [
            'tgl_cek'         => 'required',
            'berat_badan'     => 'required|numeric',
            'panjang_badan'   => 'required|numeric',
            'hb'              => 'required|numeric',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        if (Auth::user()->sekolah_id) {
            HB::updateOrCreate(
                [
                    'id' => $request->hb_id
                ],
                [
                    'puskesmas_id' => Auth::user()->puskesmas_id,
                    'sekolah_id' => Auth::user()->sekolah_id,
                    'rematri_id' => $request->rematri_id,
                    'tgl_cek' => $request->tgl_cek,
                    'berat_badan' => $request->berat_badan,
                    'panjang_badan' => $request->panjang_badan,
                    'hb' => $request->hb,
                ]
            );
            return response()->json(['success' => 'HB saved successfully.']);
        } else {
            HbPosyandu::updateOrCreate(
                [
                    'id' => $request->hb_id
                ],
                [
                    'puskesmas_id' => Auth::user()->puskesmas_id,
                    'posyandu_id' => Auth::user()->posyandu_id,
                    'rematri_id' => $request->rematri_id,
                    'tgl_cek' => $request->tgl_cek,
                    'berat_badan' => $request->berat_badan,
                    'panjang_badan' => $request->panjang_badan,
                    'hb' => $request->hb,
                ]
            );
            return response()->json(['success' => 'HB saved successfully.']);
        }
    }
    public function destroyhb($id)
    {
        if (Auth::user()->sekolah_id) {
            HB::find($id)->delete();
            return response()->json(['success' => 'HB deleted successfully.']);
        } else {
            HbPosyandu::find($id)->delete();
            return response()->json(['success' => 'HB deleted successfully.']);
        }
    }
}
