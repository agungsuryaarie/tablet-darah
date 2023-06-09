<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posyandu;
use App\Models\UserPosyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserPosyanduController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'User Posyandu';
        $posyandu = Posyandu::where('puskesmas_id', '=', Auth::user()->puskesmas_id)->get();
        if ($request->ajax()) {
            $data = UserPosyandu::where('puskesmas_id', '=', Auth::user()->puskesmas_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('posyandu', function ($data) {
                    return $data->posyandu->posyandu;
                })
                ->addColumn('foto', function ($data) {
                    if ($data->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-user/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><img src="' . url("blank.png") . '" width="30px" class="img rounded"><center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editUserposyandu"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteUserposyandu"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.userposyandu.data', compact('menu', 'posyandu'));
    }
    public function store(Request $request)
    {

        //Translate Bahasa Indonesia
        $message = array(
            'posyandu_id.required' => 'Posyandu harus dipilih.',
            'posyandu_id.unique' => 'Admin Posyandu sudah terdaftar.',
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
        if (!$request->userposyandu_id) {
            //rule tambah data tanpa user_id
            $ruleNik = 'required|max:16|min:16|unique:users_posyandu,nik';
            $ruleEmail = 'required|email|unique:users_posyandu,email';
            $rulePoid = 'required|unique:users_posyandu,posyandu_id';
        } else {
            //rule edit jika tidak ada user_id
            $lastPoid = UserPosyandu::where('id', $request->userposyandu_id)->first();
            if ($lastPoid->posyandu_id == $request->posyandu_id) {
                $rulePoid = 'required|max:16|min:16';
            } else {
                $rulePoid = 'required|unique:users_posyandu,posyandu_id';
            }
            $lastNik = UserPosyandu::where('id', $request->userposyandu_id)->first();
            if ($lastNik->nik == $request->nik) {
                $ruleNik = 'required|max:16|min:16';
            } else {
                $ruleNik = 'required|max:16|min:16|unique:users_posyandu,nik';
            }
            $lastEmail = UserPosyandu::where('id', $request->userposyandu_id)->first();
            if ($lastEmail->email == $request->email) {
                $ruleEmail = 'required|email';
            } else {
                $ruleEmail = 'required|email|unique:users_posyandu,email';
            }
        }
        $validator = Validator::make($request->all(), [
            'posyandu_id' => $rulePoid,
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
        UserPosyandu::updateOrCreate(
            [
                'id' => $request->userposyandu_id
            ],
            [
                'puskesmas_id' => Auth::user()->puskesmas_id,
                'posyandu_id' => $request->posyandu_id,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 4,
            ]
        );
        return response()->json(['success' => 'User Posyandu saved successfully.']);
    }
    public function edit($id)
    {
        $userposyandu = UserPosyandu::find($id);
        return response()->json($userposyandu);
    }

    public function destroy(UserPosyandu $user)
    {
        Storage::delete('public/foto-user/' . $user->foto);
        $user->delete();
        return response()->json(['success' => 'User Posyandu deleted successfully.']);
    }
}
