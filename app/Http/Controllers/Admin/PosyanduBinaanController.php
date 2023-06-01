<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PosyanduBinaanController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'Posyandu Binaan';
        $kecamatan = Kecamatan::get();
        $desa = Desa::where('kecamatan_id', Auth::user()->kecamatan_id)->get();
        if ($request->ajax()) {
            $data = Posyandu::where('puskesmas_id', Auth::user()->puskesmas_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('puskesmas', function ($data) {
                    return $data->puskesmas->puskesmas;
                })
                ->addColumn('desa', function ($data) {
                    return $data->desa->desa;
                })
                ->addColumn('kecamatan', function ($data) {
                    return $data->kecamatan->kecamatan;
                })
                ->addColumn('action', function ($row) {
                    return '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deletePos"><i class="fas fa-trash"></i></a><center>';
                })
                ->rawColumns(['posyandu', 'puskesmas', 'desa', 'kecamatan', 'action'])
                ->make(true);
        }

        return view('admin.posyandu-binaan.data', compact('menu', 'kecamatan', 'desa'));
    }
    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = Posyandu::where('puskesmas_id', null)->where('kecamatan_id', Auth::user()->kecamatan_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('desa', function ($data) {
                    return $data->desa->desa;
                })
                ->addColumn('kecamatan', function ($data) {
                    return $data->kecamatan->kecamatan;
                })
                ->addColumn('action', function ($row) {
                    return '<center><input type="checkbox"class="itemCheckbox" name="selectedItems[]" value="' . $row->id . '"></center>';
                })
                ->rawColumns(['kecamatan', 'desa', 'action'])
                ->make(true);
        }
        return view('admin.sekolah-binaan.data');
    }
    public function take(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'selectedItems.required' => 'Silahkan pilih posyandu anda.',
        );
        $validator = Validator::make($request->all(), [
            'selectedItems' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $selectedItems = $request->input('selectedItems', []);
        // Menggunakan Model Eloquent untuk mengupdate data
        Posyandu::whereIn('id', $selectedItems)->update([
            'puskesmas_id' => Auth::user()->puskesmas_id,
        ]);

        return response()->json(['success' => 'Posyandu Binaan saved successfully.']);
    }

    public function destroy($id)
    {
        $posyandu = Posyandu::find($id);
        $posyandu->update([
            'puskesmas_id' => null,
        ]);
        return response()->json(['success' => 'Posyandu Binaan deleted successfully.']);
    }
}
