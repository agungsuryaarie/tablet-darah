<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Puskesmas;
use App\Models\Sekolah;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SekolahBinaanController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Sekolah';
        $kecamatan = Kecamatan::get();
        if ($request->ajax()) {
            $data = Sekolah::where('puskesmas_id', Auth::user()->puskesmas_id)->latest()->get();
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
                    $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteSekolah"><i class="fas fa-trash"></i></a><center>';
                    return $btn;
                })
                ->rawColumns(['kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.sekolah-binaan.data', compact('menu'));
    }
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = Sekolah::where('puskesmas_id', null)->where('kecamatan_id', Auth::user()->kecamatan_id)->latest()->get();
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
                    return '<center><input type="checkbox"class="itemCheckbox" name="selectedItems[]" value="' . $row->id . '"></center>';
                })
                ->rawColumns(['kecamatan', 'action'])
                ->make(true);
        }
        return view('admin.sekolah-binaan.data');
    }
    public function take(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'selectedItems.required' => 'Silahkan pilih sekolah anda.',
        );
        $validator = Validator::make($request->all(), [
            'selectedItems' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $selectedItems = $request->input('selectedItems', []);
        // Menggunakan Model Eloquent untuk mengupdate data
        Sekolah::whereIn('id', $selectedItems)->update([
            'puskesmas_id' => Auth::user()->puskesmas_id,
        ]);

        return response()->json(['success' => 'Sekolah Binaan saved successfully.']);
    }

    public function destroy($id)
    {
        $sekolah = Sekolah::find($id);
        $sekolah->update([
            'puskesmas_id' => null,
        ]);
        return response()->json(['success' => 'Sekolah Binaan deleted successfully.']);
    }
}
