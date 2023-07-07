<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rematri;
use App\Models\RematriSekolah;
use App\Models\Sesi;
use App\Models\SesiRematri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SesiController extends Controller
{
    public function index()
    {
        $menu = 'Sesi';
        $sesi = Sesi::where('sekolah_id', Auth::user()->sekolah_id)->latest()->get();
        return view('admin.sesi.data', compact('menu', 'sesi'));
    }

    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'nama.required' => 'Nama Sesi harus diisi.',
            'kelas_id.required' => 'Kelas harus dipilih.',
        );
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kelas_id' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        Sesi::updateOrCreate(
            [
                'id' => $request->sesi_id
            ],
            [
                'kecamatan_id' => Auth::user()->kecamatan_id,
                'puskesmas_id' => Auth::user()->puskesmas_id,
                'sekolah_id' => Auth::user()->sekolah_id,
                'nama' => $request->nama,
                'jurusan_id' => $request->jurusan_id,
                'kelas_id' => $request->kelas_id,
            ]
        );
        $rematri = RematriSekolah::where('kelas_id', $request->kelas_id)->get();
        $sesiid  = Sesi::orderBy('id', 'DESC')->first();
        // fecth rematri
        foreach ($rematri as $r) {
            $id_rematri = $r->rematri_id;
            //simpan seluruh rematri dari kelas
            SesiRematri::create(
                [
                    'sesi_id' => $sesiid->id,
                    'kelas_id' => $sesiid->kelas_id,
                    'rematri_id' => $id_rematri,
                ]
            );
        }
        return response()->json(['success' => 'Sesi saved successfully.']);
    }


    public function rematri(Request $request, $id)
    {
        $menu = 'Sesi';
        $sesi = Sesi::where('id', Crypt::decryptString($id))->where('sekolah_id', Auth::user()->sekolah_id)->first();
        $count = RematriSekolah::where('kelas_id', $sesi->kelas_id)->where('sekolah_id', Auth::user()->sekolah_id)->count();
        if ($request->ajax()) {
            $data = SesiRematri::where('sesi_id', $sesi->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($data) {
                    return $data->rematri->nik;
                })
                ->addColumn('nama', function ($data) {
                    return $data->rematri->nama;
                })
                ->addColumn('foto', function ($data) {
                    if ($data->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-sesi/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><span class="text-danger"><i>* belum foto</i></span></center>';
                    }
                    return $foto;
                })
                ->addColumn('action', function ($row) {
                    if ($row->foto == null) {
                        $btn = '<center><a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . Crypt::encryptString($row->rematri_id) . '" data-ttd="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-xs absenRematri"><i class="fa fa-camera"></i></a></center>';
                    } else {
                        $btn = '<center><span class="badge badge-success">selesai</span></center>';
                    }
                    return $btn;
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }
        return view('admin.sesi.rematri', compact('menu', 'sesi', 'count'));
    }
    public function ttd($id, $ids, $ttd)
    {
        $menu = 'Foto';
        $rematri = Rematri::where('id', Crypt::decryptString($ids))->first();
        $sesi = Sesi::where('id', $id)->first();
        $sesifoto = SesiRematri::find($ttd);
        return view('admin.sesi.ttd', compact('menu', 'rematri', 'sesi', 'sesifoto'));
    }
    public function upload(Request $request)
    {
        $message = array(
            'foto.images' => 'File harus image.',
            'foto.mimes' => 'Foto harus jpeg,png,jpg.',
            'foto,max' => 'File maksimal 2MB.',
        );
        $this->validate($request, [
            'foto' => 'image|mimes:jpeg,png,jpg|max:2000'
        ], $message);
        $img = $request->file('foto');
        $img->storeAs('public/foto-sesi/', $img->hashName());

        SesiRematri::updateOrCreate(
            ['id' => $request->ttd_id],
            [
                'foto' => $img->hashName(),
            ]
        );
        //redirect to index
        return redirect()->route('sesi.rematri', Crypt::encryptString($request->sesi_id))->with(['status' => 'Foto uploaded successfully.']);
    }
    // fecth foto with ajax
    // ====================
    // public function foto($id)
    // {
    //     $foto = FotoSesi::where('rematri_id', $id)->first();
    //     return response()->json($foto);
    // }
    public function rematriview(Request $request, $id)
    {
        $menu = 'Hasil Sesi';
        $sesi = Sesi::where('id', $id)->first();
        $count = RematriSekolah::where('kelas_id', $sesi->kelas_id)->count();
        if ($request->ajax()) {
            $data = SesiRematri::where('sesi_id', $sesi->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($data) {
                    return $data->rematri->nik;
                })
                ->addColumn('nama', function ($data) {
                    return $data->rematri->nama;
                })
                ->addColumn('foto', function ($data) {
                    if ($data->foto != null) {
                        $foto = '<center><img src="' . url("storage/foto-sesi/" . $data->foto) . '" width="30px" class="img rounded"><center>';
                    } else {
                        $foto = '<center><span class="text-danger"><i>* belum foto</i></span></center>';
                    }
                    return $foto;
                })
                ->rawColumns(['foto'])
                ->make(true);
        }
        return view('admin.sesi.rematriview', compact('menu', 'sesi', 'count'));
    }
    public function export(Request $request, $id)
    {
        $sesi = Sesi::where('id', $id)->first();
        $data = SesiRematri::where('sesi_id', $sesi->id)->get();
        $count = RematriSekolah::where('kelas_id', $sesi->kelas_id)->count();
        // Design Table
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Laporan Data Rematri Meminum TTD');
        $sheet->setCellValue('A2', '');
        $sheet->setCellValue('A3', 'Tanggal');
        $sheet->setCellValue('A4', 'Judul Sesi');
        $sheet->setCellValue('A5', 'Kelas');
        $sheet->setCellValue('A6', 'Jumlah Rematri');
        $sheet->setCellValue('A7', '');
        $sheet->setCellValue('A8', 'No');
        $sheet->setCellValue('B8', 'NIK');
        $sheet->setCellValue('C8', 'Nama');
        $sheet->setCellValue('D8', 'Status');
        $sheet->setCellValue('B3', $sesi->created_at->isoFormat('D MMMM Y'));
        $sheet->setCellValue('B4', $sesi->nama);
        if ($sesi->jurusan_id == null) {
            $sheet->setCellValue('B5', $sesi->kelas->nama);
            $sheet->setCellValue('B6', $count);
        } else {
            $sheet->setCellValue('B5', $sesi->kelas->nama . ', ' . $sesi->jurusan->nama . ',' . $sesi->jurusan->ruangan);
            $sheet->setCellValue('B6', $count);
        }
        $no = 1;
        $row = 10;

        foreach ($data as $r) {
            if ($r->foto != null) {
                $foto = 'verified';
            } else {
                $foto = 'not verified';
            }
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $r->rematri->nik);
            $sheet->setCellValue('C' . $row, $r->rematri->nama);
            $sheet->setCellValue('D' . $row, $foto);

            $no++;
            $row++;
        }

        // Style
        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $styleColumnCenter = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $styleNumberLeft = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
            ],
        ];

        $lastRow = $row - 1;

        $sheet->getStyle('B8:B' . $lastRow)->getNumberFormat()->setFormatCode('00000000000');
        $sheet->getStyle('A1:D' . $lastRow)->applyFromArray($styleColumnCenter);
        $sheet->getStyle('A8:D' . $lastRow)->applyFromArray($styleBorder);
        $sheet->getStyle('A8:A' . $lastRow)->applyFromArray($styleColumnCenter);
        $sheet->getStyle('A3:A6')->applyFromArray($styleNumberLeft);
        $sheet->getStyle('B3:B6')->applyFromArray($styleNumberLeft);
        $sheet->getStyle('B8:B' . $lastRow)->applyFromArray($styleColumnCenter);
        $sheet->getStyle('C8:C' . $lastRow)->applyFromArray($styleColumnCenter);
        $sheet->getStyle('C10:C' . $lastRow)->applyFromArray($styleNumberLeft);
        $sheet->getStyle('D8:D' . $lastRow)->applyFromArray($styleColumnCenter);

        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A7:D7');
        $sheet->mergeCells('A8:A9');
        $sheet->mergeCells('B8:B9');
        $sheet->mergeCells('C8:C9');
        $sheet->mergeCells('D8:D9');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        // Export
        $writer = new Xlsx($spreadsheet);
        $sekolah = Auth::user()->sekolah->sekolah;
        $filename = time() . '_Laporan Hasil Sesi TTD_' . $sekolah . '.xlsx';

        $writer->save($filename);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
