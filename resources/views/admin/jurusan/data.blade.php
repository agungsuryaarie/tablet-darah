@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th>Jurusan</th>
        <th style="width: 8%">Kelas</th>
        <th style="width: 5%">Ruangan</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="kelas_id" label="Kelas">
            @foreach ($kelas as $data)
                <option value="{{ $data->id }}">{{ $data->nama }}</option>
            @endforeach
        </x-dropdown>
        @if (Auth::user()->jenjang == 'SMP')
            <x-input type="text" name="ruangan" label="Ruangan"></x-input>
        @else
            <x-input type="text" name="nama" label="Nama Jurusan"></x-input>
            <x-input type="text" name="ruangan" label="Ruangan"></x-input>
        @endif

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

            var myTable = DataTable("{{ route('jurusan.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "nama",
                    name: "nama",
                },
                {
                    data: "kelas",
                    name: "kelas",
                },
                {
                    data: "ruangan",
                    name: "ruangan",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ]);

            // Create
            var createHeading = "Tambah Jurusan";
            createModel(createHeading)

            // Edit
            var editUrl = "{{ route('jurusan.index') }}";
            var editHeading = "Edit Kelas";
            var field = ['kelas_id', 'nama', 'ruangan']; // disesuaikan dengan data yang ingin di tampilkan
            editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('jurusan.store') }}", myTable);

            // Delete
            var fitur = "Jurusan";
            var editUrl = "{{ route('jurusan.index') }}";
            var deleteUrl = "{{ route('jurusan.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
