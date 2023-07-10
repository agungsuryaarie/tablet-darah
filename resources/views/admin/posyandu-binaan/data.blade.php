@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th style="width:12%">Kode</th>
        <th>Posyandu</th>
        <th style="width:12%">Desa/Kelurahan</th>
        <th style="width:12%">Kecamatan</th>
        <th class="text-center" style="width: 5%">Action</th>
    </x-datatable>
    <x-ajaxModel size="modal-xl">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="float-left"><i class="fas fa-info-circle"></i> Pilih posyandu berdasarkan
                        binaan dari puskesmas anda.
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped data-table-posyandu">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:12%">Kode</th>
                                <th>Posyandu</th>
                                <th style="width:12%">Desa/Kelurahan</th>
                                <th style="width:12%">Kecamatan</th>
                                <th class="text-center" style="width: 5%"><input type="checkbox" id="selectAll"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-ajaxModel>
    <x-delete></x-delete>
@endsection

@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            var myTable = DataTable("{{ route('posyandu-binaan.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "kode_posyandu",
                    name: "kode_posyandu",
                },
                {
                    data: "posyandu",
                    name: "posyandu",
                },
                {
                    data: "desa",
                    name: "desa",
                },
                {
                    data: "kecamatan",
                    name: "kecamatan",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ]);

            // Create
            var createHeading = "Pilih Posyandu Binaan";
            createModel(createHeading)

            var tablePosyandu = $(".data-table-posyandu").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('posyandu-binaan.take') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "kode_posyandu",
                        name: "kode_posyandu",
                    },
                    {
                        data: "posyandu",
                        name: "posyandu",
                    },
                    {
                        data: "desa",
                        name: "desa",
                    },
                    {
                        data: "kecamatan",
                        name: "kecamatan",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            })

            // Save
            saveBtn("{{ route('take.posyandu.update') }}", myTable);

            // Delete
            var fitur = "Sekolah";
            var editUrl = "{{ route('sekolah-binaan.index') }}";
            var deleteUrl = "{{ route('sekolah-binaan.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });

        //select all
        $(document).ready(function() {
            // Checkbox "Pilih Semua"
            $('#selectAll').click(function() {
                $('.itemCheckbox').prop('checked', $(this).prop('checked'));
            });

            // Periksa apakah checkbox "Pilih Semua" harus dicentang
            $('.itemCheckbox').click(function() {
                if ($('.itemCheckbox:checked').length === $('.itemCheckbox').length) {
                    $('#selectAll').prop('checked', true);
                } else {
                    $('#selectAll').prop('checked', false);
                }
            });
        });
    </script>
@endsection
