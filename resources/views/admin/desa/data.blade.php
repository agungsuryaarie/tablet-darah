@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th style="width:12%">Kode Wilayah</th>
        <th>Desa/Kelurahan</th>
        <th style="width:15%">Kecamatan</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="kecamatan_id" label="Kecamatan">
            @foreach ($kecamatan as $data)
                <option value="{{ $data->id }}">{{ $data->kecamatan }}</option>
            @endforeach
        </x-dropdown>
        <x-input type="number" name="kode_wilayah" label="Kode Wilayah"></x-input>
        <x-input type="text" name="desa" label="Nama Desa"></x-input>
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

            var myTable = DataTable("{{ route('desa.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "kode_wilayah",
                    name: "kode_wilayah",
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
            var createHeading = "Tambah Desa";
            createModel(createHeading)

            // Edit
            var editUrl = "{{ route('desa.index') }}";
            var editHeading = "Edit Desa";
            var field = ['kecamatan_id', 'kode_wilayah',
                'desa'
            ]; // disesuaikan dengan data yang ingin di tampilkan
            editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('desa.store') }}", myTable);

            // Delete
            var fitur = "Desa";
            var editUrl = "{{ route('desa.index') }}";
            var deleteUrl = "{{ route('desa.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
