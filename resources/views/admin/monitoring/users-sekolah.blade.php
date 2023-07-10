@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <span class="badge badge-sm badge-success">Terdaftar : {{ $regis }}</span>
                            <span class="badge badge-sm badge-danger">Tidak Terdaftar : {{ $notregis }}</span>
                            <span class="badge badge-sm badge-success">Ditambahkan: {{ $added }}</span>
                            <span class="badge badge-sm badge-danger">Tidak Ditambahkan : {{ $notadded }}</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:10%">NPSN</th>
                                        <th>Nama Sekolah</th>
                                        <th>Binaan</th>
                                        <th class="text-center" style="width:10%">User</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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

            var myTable = DataTable("{{ route('userssekolah.registered') }}", [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'npsn',
                    name: 'npsn'
                },
                {
                    data: 'sekolah',
                    name: 'sekolah'
                },
                {
                    data: 'binaan',
                    name: 'binaan'
                },
                {
                    data: 'status',
                    name: 'status'
                },
            ]);
        });
    </script>
@endsection
