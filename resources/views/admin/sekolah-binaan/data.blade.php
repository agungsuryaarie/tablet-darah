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
                            <a href="javascript:void(0)" id="createNewSekolah" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:8%">NPSN</th>
                                        <th>Sekolah</th>
                                        <th style="width:12%">Jenjang</th>
                                        <th style="width:10%">Status</th>
                                        <th style="width:12%">Kecamatan</th>
                                        <th style="width:15%">Puskesmas</th>
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
        <div class="modal-dialog">
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
                    <form id="sekolahForm" name="sekolahForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="sekolah_id" id="sekolah_id">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">NPSN<span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="npsn" name="npsn" placeholder="NPSN"
                                    onkeypress="return hanyaAngka(event)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Sekolah<span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah"
                                    placeholder="Nama sekolah">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Jenjang<span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="jenjang" name="jenjang" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Status<span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="status" name="status" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtn" value="create">Simpan
                                </button>
                            </div>
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
                        <h6>Apakah anda yakin menghapus Sekolah Binaan ini ?</h6>
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
                pageLength: 10,
                lengthMenu: [10, 50, 100, 200, 500],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('sekolah-binaan.index') }}",
                columns: [{
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
                        data: "puskesmas",
                        name: "puskesmas",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $("#createNewSekolah").click(function() {
                $("#saveBtn").val("create-sekolah");
                $("#sekolah_id").val("");
                $("#sekolahForm").trigger("reset");
                $("#modelHeading").html("Tambah Sekolah");
                $("#ajaxModel").modal("show");
                $("#deleteSekolah").modal("show");
                $.ajax({
                    url: "{{ url('kecamatan/get-kecamatan') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(result) {
                        $('#kecamatan_id').html(
                            '<option value="">:::Pilih Kecamatan:::</option>');
                        $.each(result, function(key, value) {
                            $("#kecamatan_id").append('<option value="' + value
                                .id + '">' + value.kecamatan + '</option>');
                        });
                    }
                });
                $.ajax({
                    url: "{{ url('sekolah/get-jenjang') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(result) {
                        $('#jenjang').html(
                            '<option value="">:::Pilih Jenjang:::</option>');
                        $.each(result, function(key, value) {
                            $("#jenjang").append('<option value="' + value
                                .nama + '">' + value.nama + '</option>');
                        });
                    }
                });
                $.ajax({
                    url: "{{ url('sekolah/get-status') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(result) {
                        $('#status').html(
                            '<option value="">:::Pilih Status:::</option>');
                        $.each(result, function(key, value) {
                            $("#status").append('<option value="' + value
                                .kode + '">' + value.status + '</option>');
                        });
                    }
                });
            });

            $("body").on("click", ".editSekolah", function() {
                var sekolah_id = $(this).data("id");
                $.get("{{ route('sekolah-binaan.index') }}" + "/" + sekolah_id + "/edit", function(data) {
                    $("#modelHeading").html("Edit Sekolah");
                    $("#saveBtn").val("edit-sekolah");
                    $("#ajaxModel").modal("show");
                    $("#sekolah_id").val(data.id);
                    $("#npsn").val(data.npsn);
                    $("#nama_sekolah").val(data.sekolah);
                    $.ajax({
                        url: "{{ url('sekolah/get-jenjang') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(result) {
                            $('#jenjang').html(
                                '<option value="">:::Pilih Jenjang:::</option>');
                            $.each(result, function(key, value) {
                                $("#jenjang").append('<option value="' + value
                                    .nama + '">' + value.nama + '</option>');
                            });
                            $('#jenjang option[value=' +
                                data.jenjang + ']').prop(
                                'selected', true);
                        }
                    });
                    $.ajax({
                        url: "{{ url('sekolah/get-status') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(result) {
                            $('#status').html(
                                '<option value="">:::Pilih Status:::</option>');
                            $.each(result, function(key, value) {
                                $("#status").append('<option value="' + value
                                    .kode + '">' + value.status +
                                    '</option>');
                            });
                            $('#status option[value=' +
                                data.status + ']').prop(
                                'selected', true);
                        }
                    });
                    $("#alamat").val(data.alamat_jalan);
                    $.ajax({
                        url: "{{ url('kecamatan/get-kecamatan') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(result) {
                            $('#kecamatan_id').html(
                                '<option value="">:::Pilih Kecamatan:::</option>');
                            $.each(result, function(key, value) {
                                $("#kecamatan_id").append('<option value="' +
                                    value.id + '">' + value.kecamatan +
                                    '</option>');
                                $('#kecamatan_id option[value=' +
                                    data.kecamatan_id + ']').prop(
                                    'selected', true);
                            });
                        }
                    });
                    $(document).ready(function() {
                        $.ajax({
                            url: "{{ url('puskesmas/get-puskes') }}",
                            type: "POST",
                            data: {
                                kecamatan_id: data.kecamatan_id,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(result) {
                                $('#puskesmas_id').html(
                                    '<option value="">::Pilih Puskesmas::</option>'
                                );
                                $.each(result, function(key,
                                    value) {
                                    $("#puskesmas_id")
                                        .append(
                                            '<option value="' +
                                            value
                                            .id + '">' +
                                            value
                                            .puskesmas +
                                            '</option>');
                                    $('#puskesmas_id option[value=' +
                                            data.puskesmas_id + ']')
                                        .prop(
                                            'selected', true);
                                });
                            }
                        });
                    });
                });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );

                $.ajax({
                    data: $("#sekolahForm").serialize(),
                    url: "{{ route('sekolah-binaan.store') }}",
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
                                $(".alert-danger").fadeOut(5000);
                                $("#saveBtn").html("Simpan");
                                // $('#sekolahForm').trigger("reset");
                            });
                        } else {
                            table.draw();
                            alertSuccess("Sekolah Binaan saved successfully.");
                            // $('#sekolahForm').trigger("reset");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deleteSekolah", function() {
                var sekolah_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('sekolah-binaan.store') }}" + "/" + sekolah_id,
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
                                // $('#data-table').DataTable().ajax.reload();
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
