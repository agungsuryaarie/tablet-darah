@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th style="width:12%">Kode Wilayah</th>
        <th>Kabupaten</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-input type="number" name="kode_wilayah" label="Kode Wilayah"></x-input>
        <x-input type="text" name="kabupaten" label="Nama Kabupaten"></x-input>
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

            var myTable = DataTable("{{ route('kabupaten.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "kode_wilayah",
                    name: "kode_wilayah",
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
            var createHeading = "Tambah Kabupaten";
            createModel(createHeading)

            // Edit
            var editUrl = "{{ route('kabupaten.index') }}";
            var editHeading = "Edit Kabupaten";
            var field = ['kode_wilayah', 'kabupaten']; // disesuaikan dengan data yang ingin di tampilkan
            editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('kabupaten.store') }}", myTable);

            // Delete
            var fitur = "Kabupaten";
            var editUrl = "{{ route('kabupaten.index') }}";
            var deleteUrl = "{{ route('kabupaten.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)

        });
    </script>
@endsection
