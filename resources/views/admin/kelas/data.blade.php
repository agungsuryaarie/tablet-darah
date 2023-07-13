@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th>Kelas</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="nama" label="Nama Kelas">
            <option value="VII">Kelas VII</option>
            <option value="VIII">Kelas VIII</option>
            <option value="IX">Kelas IX</option>
            @if (Auth::user()->jenjang == 'SMA' or Auth::user()->jenjang == 'SMK')
                <option value="X">Kelas X</option>
                <option value="XI">Kelas XI</option>
                <option value="XII">Kelas XII</option>
            @endif
        </x-dropdown>
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

            var myTable = DataTable("{{ route('kelas.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "nama",
                    name: "nama",
                },
            ]);

            // Create
            var createHeading = "Tambah Kelas";
            createModel(createHeading)

            // Edit
            // var editUrl = "{{ route('kelas.index') }}";
            // var editHeading = "Edit Kelas";
            // var field = ['nama', ]; // disesuaikan dengan data yang ingin di tampilkan
            // editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('kelas.store') }}", myTable);

            // Delete
            // var fitur = "Kelas";
            // var editUrl = "{{ route('kelas.index') }}";
            // var deleteUrl = "{{ route('kelas.store') }}";
            // Delete(fitur, editUrl, deleteUrl, myTable)

        });
    </script>
@endsection
