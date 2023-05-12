<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rematri;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editSekolahB"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSekolahB"><i class="fas fa-trash"></i></a><center>';
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

        return view('admin.rematri-sekolah.create', compact('menu'));
    }

    public function edit()
    {
        $menu = 'Edit Data Rematri';
        return view('admin.rematri-sekolah.edit', compact('menu',));
    }
    public function getDesa(Request $request)
    {
        $data['desa'] = Desa::where("kecamatan_id", $request->kecamatan_id)->get(["desa", "id"]);
        return response()->json($data);
    }
}
