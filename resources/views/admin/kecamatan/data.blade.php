@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th style="width:12%">Kode Wilayah</th>
        <th>Kecamatan</th>
        <th style="width:10%">Kabupaten</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="kabupaten_id" label="Kabupaten">
            @foreach ($kabupaten as $data)
                <option value="{{ $data->id }}">{{ $data->kabupaten }}</option>
            @endforeach
        </x-dropdown>
        <x-input type="number" name="kode_wilayah" label="Kode Wilayah"></x-input>
        <x-input type="text" name="kecamatan" label="Nama Kecamatan"></x-input>
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

            var myTable = DataTable("{{ route('kecamatan.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "kode_wilayah",
                    name: "kode_wilayah",
                },
                {
                    data: "kecamatan",
                    name: "kecamatan",
                },
                {
                    data: "kabupaten",
                    name: "kabupaten",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ]);

            // Create
            var createHeading = "Tambah Kecamatan";
            createModel(createHeading)

            // Edit
            var editUrl = "{{ route('kecamatan.index') }}";
            var editHeading = "Edit Kecamatan";
            var field = ['kabupaten_id', 'kode_wilayah',
                'kecamatan'
            ]; // disesuaikan dengan data yang ingin di tampilkan
            editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('kecamatan.store') }}", myTable);

            // Delete
            var fitur = "Kecamatan";
            var editUrl = "{{ route('kecamatan.index') }}";
            var deleteUrl = "{{ route('kecamatan.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
