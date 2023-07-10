@extends('admin.layouts.app')
@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <x-datatable link="javascript:void(0)" label="Tambah">
        <th style="width:5%">No</th>
        <th style="width:15%">NIK</th>
        <th>Nama</th>
        <th>Puskesmas</th>
        <th style="width:20%">Email</th>
        <th class="text-center" style="width:8%">Foto</th>
        <th class="text-center" style="width: 10%">Action</th>
    </x-datatable>
    <x-ajaxModel size="modal-lg">
        <div class="row">
            <div class="col-md-6">
                <x-dropdown name="kecamatan_id" label="Kecamatan">
                    @foreach ($kecamatan as $data)
                        <option value="{{ $data->id }}">{{ $data->kecamatan }}</option>
                    @endforeach
                </x-dropdown>
            </div>
            <div class="col-md-6">
                <x-dropdown name="puskesmas_id" label="Puskesmas">
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

            var myTable = DataTable("{{ route('userpuskes.index') }}", [{
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
                    data: 'puskesmas',
                    name: 'puskesmas'
                },
                {
                    data: 'email',
                    name: 'email'
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
            var createHeading = "Tambah User Puskesmas";
            createModel(createHeading)


            $("body").on("click", ".edit", function() {
                var editId = $(this).data("id");
                var field = ['kecamatan_id', 'puskesmas_id', 'nik',
                    'nama', 'nohp', 'email'
                ];
                $.get("{{ route('userpuskes.index') }}" + "/" + editId + "/edit", function(data) {
                    $("#saveBtn").val("edit");
                    $("#ajaxModel").modal("show");
                    $("#hidden_id").val(data.id);
                    $("#modelHeading").html('Edit User Puskesmas');
                    $.each(field, function(index, value) {
                        $("#" + value).val(data[value]);
                    });
                    var kecPuskes = data.kecamatan_id;
                    $.ajax({
                        url: "{{ url('puskesmas/get-puskes') }}",
                        type: "POST",
                        data: {
                            kecamatan_id: kecPuskes,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#puskesmas_id').html(
                                '<option value="">::Pilih Puskesmas::</option>');
                            $.each(result, function(key, value) {
                                $("#puskesmas_id").append(
                                    '<option value="' +
                                    value
                                    .id + '">' + value.puskesmas +
                                    '</option>');
                                $('#puskesmas_id option[value=' +
                                    value.id + ']').prop(
                                    'selected', true);
                            });
                        }
                    });
                });
            });

            // Save
            saveBtn("{{ route('userpuskes.store') }}", myTable);

            // Delete
            var fitur = "User Puskesmas";
            var editUrl = "{{ route('userpuskes.index') }}";
            var deleteUrl = "{{ route('userpuskes.store') }}";
            Delete(fitur, editUrl, deleteUrl, myTable)

            $(document).ready(function() {
                $('#kecamatan_id').on('change', function() {
                    var idKec = this.value;
                    $("#puskesmas_id").html('');
                    $.ajax({
                        url: "{{ url('puskesmas/get-puskes') }}",
                        type: "POST",
                        data: {
                            kecamatan_id: idKec,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#puskesmas_id').html(
                                '<option value="">::Pilih Puskesmas::</option>');
                            $.each(result, function(key, value) {
                                $("#puskesmas_id").append('<option value="' +
                                    value
                                    .id + '">' + value.puskesmas +
                                    '</option>');
                            });
                        }
                    });
                });

            });

        });
    </script>
@endsection
