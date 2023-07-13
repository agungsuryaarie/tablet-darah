@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    @if (!$jurusan || !$jurusan->isFilled())
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center text-danger font-weight-bold">Silahkan tambah
                        {{ Auth::user()->jenjang == 'SMP' ? 'Ruangan' : 'Jurusan' }} yang ada di
                        sekolah {{ Auth::user()->sekolah->sekolah }}
                    </h5>
                </div>
            </div>
        </div>
    @endif
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        @if (Auth::user()->jenjang == 'SMP')
        @else
            <th>Jurusan</th>
        @endif
        <th style="{{ Auth::user()->jenjang == 'SMP' ? '' : 'width: 10%' }}">Kelas</th>
        <th style="width: 5%">Ruangan</th>
        {{-- <th class="text-center" style="width: 10%">Action</th> --}}
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="kelas_id" label="Kelas">
            @foreach ($kelas as $data)
                <option value="{{ $data->id }}">{{ $data->nama }}</option>
            @endforeach
        </x-dropdown>
        @if (Auth::user()->jenjang == 'SMP')
            <x-dropdown name="ruangan" label="Ruangan">
                <option value="1">Ruangan 1</option>
                <option value="2">Ruangan 2</option>
                <option value="3">Ruangan 3</option>
                <option value="4">Ruangan 4</option>
                <option value="5">Ruangan 5</option>
                <option value="6">Ruangan 6</option>
                <option value="3">Ruangan 7</option>
                <option value="8">Ruangan 8</option>
                <option value="9">Ruangan 9</option>
                <option value="10">Ruangan 10</option>
            </x-dropdown>
        @else
            <x-input type="text" name="nama" label="Nama Jurusan"></x-input>
            <x-dropdown name="ruangan" label="Ruangan">
                <option value="1">Ruangan 1</option>
                <option value="2">Ruangan 2</option>
                <option value="3">Ruangan 3</option>
                <option value="4">Ruangan 4</option>
                <option value="5">Ruangan 5</option>
                <option value="6">Ruangan 6</option>
                <option value="3">Ruangan 7</option>
                <option value="8">Ruangan 8</option>
                <option value="9">Ruangan 9</option>
                <option value="10">Ruangan 10</option>
            </x-dropdown>
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
                @if (Auth::user()->jenjang == 'SMP')
                @else
                    {
                        data: "nama",
                        name: "nama",
                    },
                @endif

                {
                    data: "kelas",
                    name: "kelas",
                },
                {
                    data: "ruangan",
                    name: "ruangan",
                },
                // {
                //     data: "action",
                //     name: "action",
                //     orderable: false,
                //     searchable: false,
                // },
            ]);

            // Create
            var createHeading = "Tambah Jurusan";
            createModel(createHeading)

            // Edit
            // var editUrl = "{{ route('jurusan.index') }}";
            // var editHeading = "Edit Kelas";
            // var field = ['kelas_id', 'nama', 'ruangan']; // disesuaikan dengan data yang ingin di tampilkan
            // editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('jurusan.store') }}", myTable);

            // Delete
            // var fitur = "Jurusan";
            // var editUrl = "{{ route('jurusan.index') }}";
            // var deleteUrl = "{{ route('jurusan.store') }}";
            // Delete(fitur, editUrl, deleteUrl, myTable)
        });
    </script>
@endsection
