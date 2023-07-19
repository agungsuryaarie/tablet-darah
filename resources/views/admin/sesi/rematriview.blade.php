@extends('admin.layouts.app')

@section('content')
    <x-header menu="{{ $menu }}"></x-header>
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
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <td>
                                            {{ $sesi->kelas->nama ?? '' }} - {{ $sesi->ruangan->name ?? '' }}
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
                ajax: "{{ route('sesi.rematriview', $sesi->id) }}",
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
        $(document).ready(function() {
            $('.popup-link').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });
    </script>
@endsection
