<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Rematri;
use App\Models\RematriSekolah;
use App\Models\Sesi;
use App\Models\SesiRematri;
use Carbon\Carbon;
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
use Jenssegers\Agent\Agent;
use Intervention\Image\Facades\Image;

class SesiController extends Controller
{
    public function index()
    {
        $menu = 'Sesi';
        $kelas = Kelas::where('jenjang', Auth::user()->jenjang)->get();
        $sesi = Sesi::where('sekolah_id', Auth::user()->sekolah_id)->latest()->get();
        return view('admin.sesi.data', compact('menu', 'sesi', 'kelas'));
    }

    // public function getPaginatedData(Request $request)
    // {
    //     $perPage = 6; // Number of items per page
    //     $currentPage = $request->input('page') ?? 1;

    //     // Fetch data based on the user's school_id, order by the latest date
    //     $sesi = Sesi::where('sekolah_id', Auth::user()->sekolah_id)
    //         ->latest()
    //         ->paginate($perPage, ['*'], 'page', $currentPage);

    //     // Format the 'created_at' timestamp as ISO 8601 string
    //     $sesi->getCollection()->transform(function ($item) {
    //         $item->created_at = $item->created_at->toIso8601String();
    //         return $item;
    //     });

    //     return $sesi->toJson();
    // }
    public function store(Request $request)
    {
        //Translate Bahasa Indonesia
        $message = array(
            'kelas_id.required' => 'Kelas harus dipilih.',
            // 'ruangan_id.required' => 'Ruangan harus dipilih.',
        );
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required',
            // 'ruangan_id' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if ($request->ruangan_id) {
            $rematri = RematriSekolah::where('ruangan_id', $request->ruangan_id)->get();
        } else {
            $rematri = RematriSekolah::where('kelas_id', $request->kelas_id)->where('sekolah_id', Auth::user()->sekolah_id)->get();
        }

        // Memeriksa apakah ada data rematri
        if ($rematri->isEmpty()) {
            // Jika tidak ada data rematri, tampilkan notifikasi
            return response()->json(['errors' => ['Rematri pada Ruangan ini tidak ditemukan.']]);
        }
        // Memeriksa apakah kombinasi kelas dan ruangan sudah ada dalam tabel Sesi
        $namaSesi = 'Minggu ke - ' . Carbon::now()->weekOfMonth . ' Bulan ' . Carbon::now()->isoFormat('MMMM');

        if ($request->ruangan_id) {
            $sesiExists = Sesi::where('kelas_id', $request->kelas_id)
                ->where('ruangan_id', $request->ruangan_id)
                ->where('nama', $namaSesi)
                ->exists();
        } else {
            $sesiExists = Sesi::where('kelas_id', $request->kelas_id)
                ->where('sekolah_id', Auth::user()->sekolah_id)
                ->where('nama', $namaSesi)
                ->exists();
        }

        if ($sesiExists) {
            // Jika kombinasi kelas dan ruangan sudah ada, tampilkan notifikasi
            return response()->json(['errors' => ['Kelas dan Ruangan sudah ada pada Sesi yang sama.']]);
        }
        Sesi::updateOrCreate(
            [
                'id' => $request->sesi_id
            ],
            [
                'kecamatan_id' => Auth::user()->kecamatan_id,
                'puskesmas_id' => Auth::user()->puskesmas_id,
                'sekolah_id' => Auth::user()->sekolah_id,
                'kelas_id' => $request->kelas_id,
                'ruangan_id' => $request->ruangan_id,
                'nama' => $namaSesi,
            ]
        );

        if ($request->ruangan_id) {
            $rematri = RematriSekolah::where('ruangan_id', $request->ruangan_id)->get();
        } else {
            $rematri = RematriSekolah::where('kelas_id', $request->kelas_id)->where('sekolah_id', Auth::user()->sekolah_id)->get();
        }

        $sesiid  = Sesi::orderBy('id', 'DESC')->first();
        // fecth rematri
        foreach ($rematri as $r) {
            $id_rematri = $r->rematri_id;
            //simpan seluruh rematri dari kelas
            SesiRematri::create(
                [
                    'sesi_id' => $sesiid->id,
                    'rematri_id' => $id_rematri,
                ]
            );
        }
        return response()->json(['success' => 'Sesi saved successfully.']);
    }
    public function rematri(Request $request, $id)
    {
        $menu = 'Sesi';
        $sesi = Sesi::where('id', $id)->where('sekolah_id', Auth::user()->sekolah_id)->first();
        $count = SesiRematri::where('sesi_id', $sesi->id)->count();
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
                        $foto = '<a href="' . url('storage/foto-sesi/' . $data->foto) . '" class="popup-link" target="blank">
                        <center><img src="' . url('storage/foto-sesi/' . $data->foto) . '" width="70px" class="img rounded" alt="' . $data->rematri->nama . '"><center>
                    </a>';
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
        $agent = new Agent();

        $menu = 'Foto';
        $rematri = Rematri::where('id', Crypt::decryptString($ids))->first();
        $sesi = Sesi::where('id', $id)->first();
        $sesifoto = SesiRematri::find($ttd);
        if ($agent->isMobile()) {
            return view('admin.sesi.ttd_mobile', compact('menu', 'rematri', 'sesi', 'sesifoto'));
        } else {
            return view('admin.sesi.ttd', compact('menu', 'rematri', 'sesi', 'sesifoto'));
        }
    }
    public function upload(Request $request)
    {
        $agent = new Agent();

        if ($agent->isMobile()) {
            $img = $request->file('foto');
            $filename = $img->hashName();
            // Mengompresi ukuran file foto
            $image = Image::make($img)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                }) // Mengubah ukuran gambar menjadi lebar 800px, dengan menjaga aspek rasio dan memperbesar jika perlu
                ->encode('jpg', 75); // Menyimpan dalam format JPG dengan kualitas 75%

            // Simpan foto yang sudah dikompresi
            Storage::disk('public')->put('foto-sesi/' . $filename, (string)$image);
        } else {
            $imageData = $request->input('image');
            $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $imageData = base64_decode($imageData);

            $filename = time() . '_' . $request->sesi_id . $request->rematri_id . '.jpeg';

            $imagePath = public_path('storage/foto-sesi/' . $filename);
            file_put_contents($imagePath, $imageData);

            // Kompress
            // // Mengompresi ukuran file foto menggunakan Intervention Image
            // $image = Image::make($imageData)
            //     ->resize(800, null, function ($constraint) {
            //         $constraint->aspectRatio();
            //         $constraint->upsize();
            //     })
            //     ->encode('jpg', 75); // Menyimpan dalam format JPG dengan kualitas 75%

            // // Simpan gambar ke direktori yang diinginkan
            // $imagePath = public_path('storage/foto-sesi/' . $filename);
            // $image->save($imagePath);

            // Jika Anda juga ingin menyimpan gambar yang sudah dikompresi ke penyimpanan Laravel
            Storage::disk('public')->put('foto-sesi/' . $filename, $imageData);
            // Kompress
            // Storage::disk('public')->put('foto-sesi/' . $filename, file_get_contents($imagePath));
        }
        SesiRematri::updateOrCreate(
            ['id' => $request->ttd_id],
            [
                'foto' => $filename,
            ]
        );
        //redirect to index
        return redirect()->route('sesi.rematri', $request->sesi_id)->with('toast_success', 'Photo upload successfully.');
    }

    public function rematriview(Request $request, $id)
    {
        $menu = 'Hasil Sesi';
        $sesi = Sesi::where('id', $id)->where('sekolah_id', Auth::user()->sekolah_id)->first();
        $count = SesiRematri::where('sesi_id', $sesi->id)->count();
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
                        $foto = '<a href="' . url('storage/foto-sesi/' . $data->foto) . '" class="popup-link" target="blank">
                        <center><img src="' . url('storage/foto-sesi/' . $data->foto) . '" width="70px" class="img rounded" alt="' . $data->rematri->nama . '"><center>
                    </a>';
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
        $sesi = Sesi::where('id', $id)->where('sekolah_id', Auth::user()->sekolah_id)->first();
        $data = SesiRematri::where('sesi_id', $sesi->id)->get();
        $count = SesiRematri::where('sesi_id', $sesi->id)->count();

        if (isset($sesi->kelas->nama)) {
            $kelas = $sesi->kelas->nama;
        } else {
            $kelas = '-';
        }

        if (isset($sesi->ruangan->name)) {
            $ruangan = $sesi->ruangan->name;
        } else {
            $ruangan = '-';
        }

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
        $sheet->setCellValue('B5', $kelas .  ',' . $ruangan);
        $sheet->setCellValue('B6', $count);
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
        $filename = time() . '_Laporan Hasil Sesi TTD_' . $sesi->nama . '_' . $sekolah . '.xlsx';

        $writer->save($filename);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
