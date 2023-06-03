@extends('admin.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ 'dashboard' }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0)" id="createNewUsersekolah" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:15%">NIK</th>
                                        <th>Nama</th>
                                        <th style="width:20%">Email</th>
                                        <th style="width:20%">Sekolah</th>
                                        <th class="text-center" style="width:8%">Foto</th>
                                        <th class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="usersekolahForm" name="usersekolahForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="usersekolah_id" id="usersekolah_id">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sekolah<span class="text-danger">*</span></label>
                                        <select class="browser-default custom-select select2bs4" name="sekolah_id"
                                            id="sekolah_id">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="jenjang" name="jenjang">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIK<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nik" name="nik"
                                            placeholder="NIK" autocomplete="off" value="{{ old('nik') }}"
                                            onkeypress="return hanyaAngka(event)" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama" autocomplete="off" value="{{ old('nama') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nomor Handphone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nohp" name="nohp"
                                            placeholder="Nomor Handphone" autocomplete="off" value="{{ old('nohp') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Email" autocomplete="off" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Password" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Re-Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="repassword" name="repassword"
                                            placeholder="Re-Password" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="saveBtn"
                                value="create">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    {{-- Modal Delete --}}
    <div class="modal fade" id="ajaxModelHps">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modelHeadingHps">
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <center>
                        <h6 class="text-muted">::KEPUTUSAN INI TIDAK DAPAT DIUBAH KEMBALI::</h6>
                    </center>
                    <center>
                        <h6>Apakah anda yakin menghapus User Sekolah ini ?</h6>
                    </center>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger btn-sm " id="hapusBtn"><i class="fa fa-trash"></i>
                        Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Fungsi hanyaAngka
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))

                return false;
            return true;
        }
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            var table = $(".data-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                ajax: "{{ route('usersekolah.index') }}",
                columns: [{
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
                ]
            });

            $("#createNewUsersekolah").click(function() {
                $("#saveBtn").val("create-usersekolah");
                $("#usersekolah_id").val("");
                $("#usersekolahForm").trigger("reset");
                $("#modelHeading").html("Tambah User Sekolah");
                $("#ajaxModel").modal("show");
                $("#deleteUsersekolah").modal("show");
                $.ajax({
                    url: "{{ url('sekolah/get-sekolah-puskes') }}",
                    type: "POST",
                    data: {
                        puskesmas_id: {{ Auth::user()->puskesmas_id }},
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result == "") {
                            $('#sekolah_id').html(
                                '<option disable>Pilih Sekolah Binaan Terlebih dahulu</option>'
                            );
                        } else {
                            $('#sekolah_id').html(
                                '<option value="">:::Pilih Sekolah:::</option>');
                        }
                        $.each(result, function(key, value) {
                            $("#sekolah_id").append('<option value="' +
                                value
                                .id + '">' + value.sekolah +
                                '</option>');
                        });
                    }
                });
                $('#sekolah_id').on('change', function() {
                    var idSekolah = this.value;
                    console.log(idSekolah);
                    $("#jenjang").html('');
                    $.ajax({
                        url: "{{ url('sekolah/get-jenjang-auto') }}",
                        type: "POST",
                        data: {
                            sekolah_id: idSekolah,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $.each(result.jenjang, function(key, value) {
                                $("#jenjang").val(value.jenjang);
                            });
                        }
                    });
                });
            });

            $("body").on("click", ".editUsersekolah", function() {
                var usersekolah_id = $(this).data("id");
                console.log(usersekolah_id);
                $.get("{{ route('usersekolah.index') }}" + "/" + usersekolah_id + "/edit", function(data) {
                    $("#modelHeading").html("Edit User Sekolah");
                    $("#saveBtn").val("edit-usersekolah");
                    $("#ajaxModel").modal("show");
                    $("#usersekolah_id").val(data.id);
                    $("#jenjang").val(data.jenjang);
                    $("#sekolah_id").val(data.sekolah_id);
                    $.ajax({
                        url: "{{ url('sekolah/get-sekolah') }}",
                        type: "POST",
                        data: {
                            kecamatan_id: {{ Auth::user()->kecamatan_id }},
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#sekolah_id').html(
                                '<option value="">:::Pilih Sekolah:::</option>');
                            $.each(result, function(key, value) {
                                $("#sekolah_id").append('<option value="' +
                                    value
                                    .id + '">' + value.sekolah +
                                    '</option>');
                                $('#sekolah_id option[value=' +
                                        data.sekolah_id + ']')
                                    .prop(
                                        'selected', true);
                            });
                        }
                    });
                    $('#sekolah_id').on('change', function() {
                        var idSekolah = this.value;
                        console.log(idSekolah);
                        $("#jenjang").html('');
                        $.ajax({
                            url: "{{ url('sekolah/get-jenjang-auto') }}",
                            type: "POST",
                            data: {
                                sekolah_id: idSekolah,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(result) {
                                $.each(result.jenjang, function(key, value) {
                                    $("#jenjang").val(value.jenjang);
                                });
                            }
                        });
                    });
                    $("#nik").val(data.nik);
                    $("#nama").val(data.nama);
                    $("#nohp").val(data.nohp);
                    $("#email").val(data.email);
                });
            });
            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );
                $.ajax({
                    data: $("#usersekolahForm").serialize(),
                    url: "{{ route('usersekolah.store') }}",
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        if (data.errors) {
                            $('.alert-danger').html('');
                            $.each(data.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' +
                                    value +
                                    '</li></strong>');
                                $(".alert-danger").fadeOut(3000);
                                $("#saveBtn").html("Simpan");
                                // $('#userForm').trigger("reset");
                            });
                        } else {
                            table.draw();
                            alertSuccess("User Sekolah saved successfully.");
                            $('#usersekolahForm').trigger("reset");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deleteUsersekolah", function() {
                var usersekolah_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('usersekolah.store') }}" + "/" + usersekolah_id +
                            "/destroy",
                        data: {
                            _token: "{!! csrf_token() !!}",
                        },
                        success: function(data) {
                            if (data.errors) {
                                $('.alert-danger').html('');
                                $.each(data.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<strong><li>' +
                                        value +
                                        '</li></strong>');
                                    $(".alert-danger").fadeOut(5000);
                                    $("#hapusBtn").html(
                                        "<i class='fa fa-trash'></i>Hapus"
                                    );
                                });
                            } else {
                                table.draw();
                                alertSuccess(data.success);
                                $("#hapusBtn").html(
                                    "<i class='fa fa-trash'></i>Hapus");
                                $('#ajaxModelHps').modal('hide');
                            }
                        },
                    });
                });
            });
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
