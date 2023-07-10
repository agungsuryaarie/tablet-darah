@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th style="width:15%">NIK</th>
        <th>Nama</th>
        <th style="width:20%">Email</th>
        <th style="width:20%">Sekolah</th>
        <th class="text-center" style="width:8%">Foto</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="modal-lg">
        <div class="row">
            <div class="col-md-12">
                <x-dropdown name="sekolah_id" label="Sekolah">
                    @foreach ($sekolah as $data)
                        <option value="{{ $data->id }}">{{ $data->sekolah }}</option>
                    @endforeach
                </x-dropdown>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-input type="text" name="nik" label="NIK"></x-input>
            </div>
            <div class="col-md-6">
                <x-input type="text" name="nama" label="Nama"></x-input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-input type="text" name="nohp" label="Nomor Handphone"></x-input>
            </div>
            <div class="col-md-6">
                <x-input type="email" name="email" label="Email"></x-input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-input type="password" name="password" label="Password"></x-input>
            </div>
            <div class="col-md-6">
                <x-input type="password" name="repassword" label="Re-Password"></x-input>
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

            var myTable = DataTable("{{ route('usersekolah.index') }}", [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'sekolah',
                    name: 'sekolah'
                },
                {
                    data: 'foto',
                    name: 'foto'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]);

            // Create
            var createHeading = "Tambah User Sekolah";
            createModel(createHeading)

            // Edit
            var editUrl = "{{ route('usersekolah.index') }}";
            var editHeading = "Edit Sekolah";
            var field = ['sekolah_id', 'nik', 'nama', 'nohp',
                'email'
            ]; // disesuaikan dengan data yang ingin di tampilkan
            editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('usersekolah.store') }}", myTable);

            // Delete
            var fitur = "User Sekolah";
            var editUrl = "{{ route('usersekolah.index') }}";
            var deleteUrl = "{{ route('usersekolah.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
