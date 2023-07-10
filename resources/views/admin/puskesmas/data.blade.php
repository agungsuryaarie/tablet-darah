@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th style="width:12%">Kode Puskesmas</th>
        <th>Puskesmas</th>
        <th style="width:12%">Kecamatan</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="kecamatan_id" label="Kecamatan">
            @foreach ($kecamatan as $data)
                <option value="{{ $data->id }}">{{ $data->kecamatan }}</option>
            @endforeach
        </x-dropdown>
        <x-input type="text" name="kode_puskesmas" label="Kode Puskesmas"></x-input>
        <x-input type="text" name="puskesmas" label="Nama Puskesmas"></x-input>
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

            var myTable = DataTable("{{ route('puskesmas.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "kode_puskesmas",
                    name: "kode_puskesmas",
                },
                {
                    data: "puskesmas",
                    name: "puskesmas",
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
            var createHeading = "Tambah Puskesmas";
            createModel(createHeading)

            // Edit
            var editUrl = "{{ route('puskesmas.index') }}";
            var editHeading = "Edit Puskesmas";
            var field = ['kecamatan_id', 'kode_puskesmas',
                'puskesmas'
            ]; // disesuaikan dengan data yang ingin di tampilkan
            editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('puskesmas.store') }}", myTable);

            // Delete
            var fitur = "Puskesmas";
            var editUrl = "{{ route('puskesmas.index') }}";
            var deleteUrl = "{{ route('puskesmas.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
