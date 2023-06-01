@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Sesi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('sesi-posyandu.index') }}">Sesi</a></li>
                        <li class="breadcrumb-item active">Detail Sesi</li>
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
                                        <td>{{ $sesip->created_at->isoFormat('D MMMM Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%">Judul Sesi</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 40%">{{ $sesip->nama }}</td>
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
                                                <th class="text-center" style="width: 8%">Action</th>
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
@section('modal')
    {{-- Modal Foto --}}
    <div class="modal fade" id="ajaxFoto">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeadingFoto"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <center>
                        <div class="fotoDiv"></div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" id="back" class="btn btn-secondary btn-sm"
                        onclick="window.location.reload();">Kembali</button>
                </div>
            </div>
        </div>
    </div>
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
                ajax: "{{ route('sesi.posyandu.rematri', Crypt::encryptString($sesip->id)) }}",
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
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });
            $("body").on("click", ".absenRematriP", function() {
                var sesip_id = {{ $sesip->id }};
                var rematri_posyandu_id = $(this).data("id");
                var ttd_posyandu_id = $(this).data("ttd");
                var url = "{{ url('sesi-posyandu/ttd') }}" + "/" + sesip_id + "/" + rematri_posyandu_id +
                    "/" +
                    ttd_posyandu_id;
                window.location = url;
            });
        });
    </script>
@endsection
