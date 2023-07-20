@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    @if (!$ruangan || !$ruangan->isFilled())
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-center text-danger font-weight-bold"><i class="fa fa-info-circle"></i>UNTUK MENAMBAHKAN
                        REMATRI, SILAHKAN TAMBAHKAN
                        RUANGAN TERLEBIH DAHULU.
                    </h6>
                </div>
            </div>
        </div>
    @endif
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th>Kelas</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="kelas_id" label="Kelas">
            @foreach ($kelas as $room)
                <option value="{{ $room->id }}">{{ $room->nama }}</option>
            @endforeach
        </x-dropdown>
        <x-input type="text" name="name" label="Nama Ruangan"
            placeholder="contoh : Angka (1,2,3) atau huruf (A,B,C) atau Jurusan">
        </x-input>
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

            var myTable = DataTable("{{ route('ruangan.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "kelas",
                    name: "kelas",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ]);

            // Create
            var createHeading = "Tambah Kelas";
            createModel(createHeading)

            // Edit
            var editUrl = "{{ route('ruangan.index') }}";
            var editHeading = "Edit Kelas";
            var field = ['kelas_id', 'name', ]; // disesuaikan dengan data yang ingin di tampilkan
            editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('ruangan.store') }}", myTable);

            // Delete
            // var fitur = "Kelas";
            // var editUrl = "{{ route('kelas.index') }}";
            // var deleteUrl = "{{ route('kelas.store') }}";
            // Delete(fitur, editUrl, deleteUrl, myTable)

        });
    </script>
@endsection
