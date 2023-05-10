<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\UserSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserSekolahController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'User Sekolah';
        $sekolah = Sekolah::where('puskesmas_id', '=', Auth::user()->puskesmas_id)->get();
        // dd($sekolah);
        if ($request->ajax()) {
            $data = UserSekolah::where('puskesmas_id', '=', Auth::user()->puskesmas_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('foto', function ($data) {
                    if ($data->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-user/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><img src="' . url("storage/foto-user/blank.png") . '" width="30px" class="img rounded"><center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editUsersekolah"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteUsersekolah"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.usersekolah.data', compact('menu', 'sekolah'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        //Translate Bahasa Indonesia
        $message = array(
            'sekolah_id.required' => 'Sekolah harus dipilih.',
            'nik.required' => 'NIK harus diisi.',
            'nik.numeric' => 'NIK harus angka.',
            'nik.max' => 'NIK maksimal 16 digit.',
            'nik.min' => 'NIK minimal 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nama.required' => 'Nama harus diisi.',
            'nohp.required' => 'Nomor Handphone harus diisi.',
            'nohp.numeric' => 'Nomor Handphone harus angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Penulisan email tidak benar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'repassword.required' => 'Harap konfirmasi password.',
            'repassword.same' => 'Password harus sama.',
            'repassword.min' => 'Password minimal 8 karakter.',
        );
        //Check If Field Unique
        if (!$request->usersekolah_id) {
            //rule tambah data tanpa user_id
            $ruleNik = 'required|max:16|min:16|unique:users_sekolah,nik';
            $ruleEmail = 'required|email|unique:users_sekolah,email';
        } else {
            //rule edit jika tidak ada user_id
            $lastNik = UserSekolah::where('id', $request->usersekolah_id)->first();
            if ($lastNik->nik == $request->nik) {
                $ruleNik = 'required|max:16|min:16';
            } else {
                $ruleNik = 'required|max:16|min:16|unique:users_sekolah,nik';
            }
            $lastEmail = UserSekolah::where('id', $request->usersekolah_id)->first();
            if ($lastEmail->email == $request->email) {
                $ruleEmail = 'required|email';
            } else {
                $ruleEmail = 'required|email|unique:users_sekolah,email';
            }
        }
        $validator = Validator::make($request->all(), [
            'sekolah_id' => 'required',
            'nik' => $ruleNik,
            'nama' => 'required|max:255',
            'nohp' => 'required|numeric',
            'email' => $ruleEmail,
            'password' => 'required|min:8',
            'repassword' => 'required|same:password|min:8',
        ], $message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        UserSekolah::updateOrCreate(
            [
                'id' => $request->usersekolah_id
            ],
            [
                'puskesmas_id' => Auth::user()->puskesmas_id,
                'sekolah_id' => $request->sekolah_id,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 3,
            ]
        );
        return response()->json(['success' => 'User Sekolah saved successfully.']);
    }
    public function edit($id)
    {
        $usersekolah = UserSekolah::find($id);
        return response()->json($usersekolah);
    }

    public function destroy(UserSekolah $user)
    {
        Storage::delete('public/foto-user/' . $user->foto);
        $user->delete();
        return response()->json(['success' => 'User Sekolah deleted successfully.']);
    }
}
