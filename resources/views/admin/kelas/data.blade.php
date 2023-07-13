@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    @if (!$kelas || !$kelas->isFilled())
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center text-danger font-weight-bold">Silahkan tambah kelas yang ada di
                        sekolah {{ Auth::user()->sekolah->sekolah }}
                    </h5>
                </div>
            </div>
        </div>
    @endif
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th>Kelas</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="nama" label="Nama Kelas">
            @if (Auth::user()->jenjang == 'SMP')
                <option value="VII">Kelas VII</option>
                <option value="VIII">Kelas VIII</option>
                <option value="IX">Kelas IX</option>
            @else
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
