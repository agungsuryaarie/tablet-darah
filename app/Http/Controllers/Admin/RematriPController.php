<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\RematriP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class RematriPController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Rematri';
        $kecamatan = Kecamatan::get();
        if ($request->ajax()) {
            $data = RematriP::where('posyandu_id', '=', Auth::user()->posyandu_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editSekolahB"><i class="fas fa-edit"></i></a>';
                    $btn = '<center>' . $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSekolahB"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.rematri-posyandu.data', compact('menu'));
    }

    public function create()
    {
        $menu = 'Tambah Data Rematri';

        return view('admin.rematri-posyandu.create', compact('menu'));
    }

    public function edit()
    {
        $menu = 'Edit Data Rematri';
        return view('admin.rematri-posyandu.edit', compact('menu',));
    }
    public function getDesa(Request $request)
    {
        $data['desa'] = Desa::where("kecamatan_id", $request->kecamatan_id)->get(["desa", "id"]);
        return response()->json($data);
    }
}
