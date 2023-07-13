@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    {{-- @if (!$kelas || !$kelas->isFilled())
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center text-danger font-weight-bold">Silahkan tambah kelas yang ada di
                        sekolah {{ Auth::user()->sekolah->sekolah }}
                    </h5>
                </div>
            </div>
        </div>
    @endif --}}
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th>Kelas</th>
        <th>Ruangan</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="kelas_id" label="Kelas">
            @foreach ($kelas as $room)
                <option value="{{ $room->id }}">{{ $room->nama }}</option>
            @endforeach
        </x-dropdown>
        <x-input type="text" name="nama" label="Nama Ruangan"></x-input>
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
            saveBtn("{{ route('ruangan.store') }}", myTable);

            // Delete
            // var fitur = "Kelas";
            // var editUrl = "{{ route('kelas.index') }}";
            // var deleteUrl = "{{ route('kelas.store') }}";
            // Delete(fitur, editUrl, deleteUrl, myTable)

        });
    </script>
@endsection
