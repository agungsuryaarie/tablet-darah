@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('sesi.index') }}">Sesi</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="invoice p-3 mb-3">
                        <div class="col-sm-4 invoice-col mt-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>{{ $sesi->created_at->isoFormat('D MMMM Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%">Judul Sesi</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 40%">{{ $sesi->nama }}</td>
                                    </tr>
                                    @if ($sesi->jurusan_id != null)
                                        <tr>
                                            <td>Jurusan</td>
                                            <td>:</td>
                                            <td>{{ $sesi->jurusan->nama }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <td>
                                            @if ($sesi->jurusan_id == null)
                                                {{ $sesi->kelas->nama }}
                                            @else
                                                {{ $sesi->kelas->nama }} {{ $sesi->jurusan->nama }}
                                                {{ $sesi->jurusan->ruangan }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Rematri</td>
                                        <td>:</td>
                                        <td>{{ $count }} orang</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mb-5">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped data-table">
                                        <thead>
                                            <tr>
                                                <th style="width:5%">No</th>
                                                <th style="width:15%">NIK</th>
                                                <th>Nama</th>
                                                <th class="text-center" style="width:10%">Foto</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            var table = $(".data-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('sesi.rematri', Crypt::encryptString($sesi->id)) }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "nik",
                        name: "nik",
                    },
                    {
                        data: "nama",
                        name: "nama",
                    },
                    {
                        data: "foto",
                        name: "foto",
                    },
                ],
            });
        });
    </script>
@endsection
