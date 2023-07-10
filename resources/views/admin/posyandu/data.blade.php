@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th style="width:12%">Kode Posyandu</th>
        <th>Posyandu</th>
        <th style="width:12%">Desa/Kelurahan</th>
        <th style="width:12%">Kecamatan</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="">
        <x-dropdown name="kecamatan_id" label="Kecamatan">
            @foreach ($kecamatan as $data)
                <option value="{{ $data->id }}">{{ $data->kecamatan }}</option>
            @endforeach
        </x-dropdown>
        <x-dropdown name="desa_id" label="Desa">
        </x-dropdown>
        <x-input type="text" name="kode_posyandu" label="Kode Posyandu"></x-input>
        <x-input type="text" name="posyandu" label="Nama Posyandu"></x-input>
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

            var myTable = DataTable("{{ route('posyandu.index') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "kode_posyandu",
                    name: "kode_posyandu",
                },
                {
                    data: "posyandu",
                    name: "posyandu",
                },
                {
                    data: "desa",
                    name: "desa",
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
            var createHeading = "Tambah Posyandu";
            createModel(createHeading)

            // Edit
            var editUrl = "{{ route('posyandu.index') }}";
            var editHeading = "Edit Posyandu";
            var field = ['kecamatan_id', 'desa_id', 'kode_posyandu',
                'posyandu'
            ]; // disesuaikan dengan data yang ingin di tampilkan
            editModel(editUrl, editHeading, field)

            // Save
            saveBtn("{{ route('posyandu.store') }}", myTable);

            // Delete
            var fitur = "Posyandu";
            var editUrl = "{{ route('posyandu.index') }}";
            var deleteUrl = "{{ route('posyandu.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)

            $(document).ready(function() {
                $('select[name="kecamatan_id"]').on('change', function() {
                    var kecamatanId = $(this).val();
                    if (kecamatanId) {
                        $.ajax({
                            url: "{{ url('desa/get-desa') }}",
                            type: 'POST',
                            data: {
                                kecamatan_id: kecamatanId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                $('select[name="desa_id"]').empty();
                                $('select[name="desa_id"]').append(
                                    '<option value="">Pilih Desa</option>');
                                $.each(data, function(key, value) {
                                    $('select[name="desa_id"]').append(
                                        '<option value="' + value.id +
                                        '">' + value.desa + '</option>'
                                    );
                                });
                            }
                        });
                    } else {
                        $('select[name="desa_id"]').empty();
                        $('select[name="desa_id"]').append('<option value="">Pilih Desa</option>');
                    }
                });
            });
        });
    </script>
@endsection
