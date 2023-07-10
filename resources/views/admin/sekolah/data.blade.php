@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th style="width:8%">NPSN</th>
        <th>Sekolah</th>
        <th style="width:12%">Jenjang</th>
        <th style="width:10%">Status</th>
        <th style="width:12%">Kecamatan</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="kecamatan_id" label="Kecamatan">
            @foreach ($kecamatan as $data)
                <option value="{{ $data->id }}">{{ $data->kecamatan }}</option>
            @endforeach
        </x-dropdown>
        <x-input type="number" name="npsn" label="NPSN"></x-input>
        <x-input type="text" name="sekolah" label="Nama Sekolah"></x-input>
        <x-dropdown name="jenjang" label="Jenjang">
            @foreach ($jenjang as $data)
                <option value="{{ $data->nama }}">{{ $data->nama }}</option>
            @endforeach
        </x-dropdown>
        <x-dropdown name="status" label="Status">
            @foreach ($status as $data)
                <option value="{{ $data->status }}">{{ $data->nama }}</option>
            @endforeach
        </x-dropdown>
        <x-textarea name="alamat_jalan" label="Alamat"></x-textarea>
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

            var myTable = DataTable("{{ route('sekolah.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "npsn",
                    name: "npsn",
                },
                {
                    data: "sekolah",
                    name: "sekolah",
                },
                {
                    data: "jenjang",
                    name: "jenjang",
                },
                {
                    data: "status",
                    name: "status",
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
            var createHeading = "Tambah Sekolah";
            createModel(createHeading)

            // Edit
            var editUrl = "{{ route('sekolah.index') }}";
            var editHeading = "Edit Sekolah";
            var field = ['kecamatan_id', 'npsn', 'sekolah', 'jenjang',
                'status', 'alamat_jalan'
            ]; // disesuaikan dengan data yang ingin di tampilkan
            editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('sekolah.store') }}", myTable);

            // Delete
            var fitur = "Sekolah";
            var editUrl = "{{ route('sekolah.index') }}";
            var deleteUrl = "{{ route('sekolah.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
