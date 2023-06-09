<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Puskesmas;
use App\Models\UserPuskesmas;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserPuskesController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'User Puskesmas';
        $kecamatan = Kecamatan::latest()->get();
        if ($request->ajax()) {
            $data = UserPuskesmas::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('foto', function ($data) {
                    if ($data->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-user/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><img src="' . url("blank.png") . '" width="30px" class="img rounded"><center>';
                    }
                    return $foto;
                })
                ->addColumn('puskesmas', function ($data) {
                    return $data->puskesmas->puskesmas;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editUserpuskes"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteUserpuskes"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.user.data', compact('menu', 'kecamatan'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        //Translate Bahasa Indonesia
        $message = array(
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'puskesmas_id.required' => 'Puskesmas harus dipilih.',
            'puskesmas_id.unique' => 'Admin Puskesmas sudah terdaftar.',
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
        if (!$request->userpuskes_id) {
            //rule tambah data tanpa user_id
            $ruleNik = 'required|max:16|min:16|unique:users_puskesmas,nik';
            $ruleEmail = 'required|email|unique:users_puskesmas,email';
            $rulePid = 'required|unique:users_puskesmas,puskesmas_id';
        } else {
            //rule edit jika tidak ada user_id
            $lastPid = UserPuskesmas::where('id', $request->userpuskes_id)->first();
            if ($lastPid->puskesmas_id == $request->puskesmas_id) {
                $rulePid = 'required';
            } else {
                $rulePid = 'required|unique:users_puskesmas,puskesmas_id';
            }
            $lastNik = UserPuskesmas::where('id', $request->userpuskes_id)->first();
            if ($lastNik->nik == $request->nik) {
                $ruleNik = 'required|max:16|min:16';
            } else {
                $ruleNik = 'required|max:16|min:16|unique:users_puskesmas,nik';
            }
            $lastEmail = UserPuskesmas::where('id', $request->userpuskes_id)->first();
            if ($lastEmail->email == $request->email) {
                $ruleEmail = 'required|email';
            } else {
                $ruleEmail = 'required|email|unique:users_puskesmas,email';
            }
        }
        $validator = Validator::make($request->all(), [
            'kecamatan_id' => 'required',
            'puskesmas_id' => $rulePid,
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
        UserPuskesmas::updateOrCreate(
            [
                'id' => $request->userpuskes_id
            ],
            [
                'kecamatan_id' => $request->kecamatan_id,
                'puskesmas_id' => $request->puskesmas_id,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 2,
            ]
        );
        return response()->json(['success' => 'User Puskesmas saved successfully.']);
    }
    public function edit($id)
    {
        $user = UserPuskesmas::find($id);
        return response()->json($user);
    }

    public function destroy(UserPuskesmas $user)
    {
        Storage::delete('public/foto-user/' . $user->foto);
        $user->delete();
        return response()->json(['success' => 'User Sekolah deleted successfully.']);
    }
    public function getPuskes(Request $request)
    {
        $data['puskesmas'] = Puskesmas::where("kecamatan_id", $request->kecamatan_id)->get(["puskesmas", "id"]);
        return response()->json($data);
    }
}
