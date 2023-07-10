<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use App\Models\Kecamatan;
use App\Models\Sekolah;
use App\Models\Status;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Sekolah';
        $kecamatan = Kecamatan::latest()->get();
        $jenjang = Jenjang::latest()->get();
        $status = Status::latest()->get();
        if ($request->ajax()) {
            $data = Sekolah::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status === 'N') {
                        return 'Negeri';
                    } else {
                        return 'Swasta';
                    }
                })
                ->addColumn('kecamatan', function ($data) {
                    return $data->kecamatan->kecamatan;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.sekolah.data', compact('menu', 'kecamatan', 'jenjang', 'status'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kecamatan_id.required' => 'Kecamatan harus dipilih.',
            'sekolah.required' => 'Nama Sekolah harus diisi.',
            'npsn.required' => 'NPSN harus diisi.',
            'npsn.max' => 'NPSN maksimal 8 digit.',
            'npsn.min' => 'NPSN minimal 8 digit.',
            'npsn.unique' => 'NPSN sudah terdaftar.',
            'jenjang.required' => 'Jenjang harus dipilih.',
            'status.required' => 'Status harus dipilih.',
            'alamat_jalan.required' => 'Alamat harus diisi.',
            'alamat_jalan..max' => 'Alamat melebihi batas maksimal karakter.',
        );
        //Check If Field Unique
        if (!$request->hidden_id) {
            //rule tambah data tanpa user_id
            $ruleNpsn = 'required|max:8|min:8|unique:sekolah,npsn';
        } else {
            //rule edit jika tidak ada user_id
            $lastNpsn = Sekolah::where('id', $request->hidden_id)->first();
            if ($lastNpsn->npsn == $request->npsn) {
                $ruleNpsn = 'required|max:8|min:8';
            } else {
                $ruleNpsn = 'required|max:8|min:8|unique:sekolah,npsn';
            }
        }
        $validator = Validator::make($request->all(), [
            'kecamatan_id' => 'required',
            'npsn' => $ruleNpsn,
            'sekolah' => 'required',
            'jenjang' => 'required',
            'status' => 'required',
            'alamat_jalan' => 'required|max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        Sekolah::updateOrCreate(
            [
                'id' => $request->hidden_id
            ],
            [
                'kecamatan_id' => $request->kecamatan_id,
                'puskesmas_id' => null,
                'npsn' => $request->npsn,
                'sekolah' => $request->sekolah,
                'jenjang' => $request->jenjang,
                'status' => $request->status,
                'alamat_jalan' => $request->alamat_jalan,
            ]
        );
        return response()->json(['success' => 'Sekolah saved successfully.']);
    }

    public function edit($id)
    {
        $sekolah = Sekolah::find($id);
        return response()->json($sekolah);
    }

    public function destroy($id)
    {
        Sekolah::find($id)->delete();
        return response()->json(['success' => 'Sekolah deleted successfully.']);
    }

    public function getSekolah(Request $request)
    {
        $data = Sekolah::where('puskesmas_id', $request->puskesmas_id)->get(["sekolah", "id", 'jenjang']);
        return response()->json($data);
    }

    public function getSekolahPuskes(Request $request)
    {
        $data = Sekolah::where('puskesmas_id', $request->puskesmas_id)->get(["sekolah", "id", 'jenjang']);
        return response()->json($data);
    }


    public function getJenjang()
    {
        $data = Jenjang::get(["nama"]);
        return response()->json($data);
    }

    public function getStatus()
    {
        $data = Status::get(["status", "nama"]);
        return response()->json($data);
    }

    public function getJenjangAuto(Request $request)
    {
        $data['jenjang'] = Sekolah::where("id", $request->hidden_id)
            ->get();
        return response()->json($data);
    }
}
