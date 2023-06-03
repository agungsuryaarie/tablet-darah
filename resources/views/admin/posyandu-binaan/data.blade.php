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
                            <a href="javascript:void(0)" id="choosePosyandu" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:12%">Kode</th>
                                        <th>Posyandu</th>
                                        <th style="width:12%">Desa/Kelurahan</th>
                                        <th style="width:12%">Kecamatan</th>
                                        <th class="text-center" style="width: 5%">Action</th>
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
    <div class="modal fade" id="ajaxModelPosyandu" aria-hidden="true">
        <div class="modal-dialog modal-xl">
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
                    <form id="posyanduForm" name="posyanduForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="posyandu_id" id="posyandu_id">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="float-left"><i class="fas fa-info-circle"></i> Pilih posyandu berdasarkan
                                        binaan dari puskesmas anda.
                                    </h6>
                                    <a href="javascript:void(0)" id="createNewPosyandu"
                                        class="btn btn-info btn-xs float-right">
                                        <i class="fas fa-plus-circle"></i> Tambah</a>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped data-table-posyandu">
                                        <thead>
                                            <tr>
                                                <th style="width:5%">No</th>
                                                <th style="width:12%">Kode</th>
                                                <th>Posyandu</th>
                                                <th style="width:12%">Desa/Kelurahan</th>
                                                <th style="width:12%">Kecamatan</th>
                                                <th class="text-center" style="width: 5%"><input type="checkbox"
                                                        id="selectAll"></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="take"
                                    value="create">Tambahkan
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
                    <form id="NewposyanduForm" name="NewposyanduForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="posyandu_id" id="posyandu_id">
                        <input type="hidden" name="kecamatan_id" value="{{ Auth::user()->kecamatan_id }}"
                            id="kecamatan_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Desa/Keluarahan<span class="text-danger">*</span></label>
                                <select class="browser-default custom-select select2bs4" name="desa_id" id="desa_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kode Posyandu<span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="kode_posyandu" name="kode_posyandu"
                                    placeholder="Kode Posyandu">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Posyandu<span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_posyandu" name="nama_posyandu"
                                    placeholder="Nama Posyandu">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtn"
                                    value="create">Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                        <h6>Apakah anda yakin menghapus Posyandu Binaan ini ?</h6>
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
                ajax: "{{ route('posyandu-binaan.index') }}",
                columns: [{
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
                ],
            });

            $("#choosePosyandu").click(function() {
                $("#take").val("create-posyandu");
                $("#posyandu_id").val("");
                $("#posyanduForm").trigger("reset");
                $("#modelHeading").html("Pilih Posyandu Binaan");
                $("#ajaxModelPosyandu").modal("show");
                if ($.fn.DataTable.isDataTable('.data-table-posyandu')) {
                    $('.data-table-posyandu').DataTable().destroy();
                }
                var tablePosyandu = $(".data-table-posyandu").DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [10, 50, 100, 200, 500],
                    lengthChange: true,
                    autoWidth: false,
                    ajax: "{{ route('posyandu-binaan.take') }}",
                    columns: [{
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
                    ],
                });

                $("#saveBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                    );

                    $.ajax({
                        data: $("#NewposyanduForm").serialize(),
                        url: "{{ url('posyandu-binaan/save') }}",
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
                                    // $('#posyanduForm').trigger("reset");
                                });
                            } else {
                                tablePosyandu.draw();
                                alertSuccess("Posyandu berhasil ditambah");
                                // $('#posyanduForm').trigger("reset");
                                $("#saveBtn").html("Simpan");
                                $('#ajaxModel').modal('hide');
                            }
                        },
                    });
                });

            });
            $("#take").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> sedang diproses...</i></span>"
                ).attr('disabled', 'disabled');

                $.ajax({
                    data: $("#posyanduForm").serialize(),
                    url: "{{ route('take.posyandu.update') }}",
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
                                $("#take").html("Tambahkan").removeAttr("disabled");
                            });
                        } else {
                            table.draw();
                            alertSuccess("Posyandu Binaan berhasil ditambah");
                            $("#take").html("Tambahkan").removeAttr("disabled");
                            $('#ajaxModelPosyandu').modal('hide');
                        }
                    },
                });
            });

            $("#createNewPosyandu").click(function() {
                $("#saveBtn").val("create-posyandu");
                $("#posyandu_id").val("");
                $("#NewposyanduForm").trigger("reset");
                $("#modelHeading").html("Tambah Posyandu");
                $("#ajaxModel").modal("show");
                $("#deletePos").modal("show");
                var idKec = $("#kecamatan_id").val();
                $.ajax({
                    url: "{{ url('posyandu-binaan/get-desa') }}",
                    type: "POST",
                    data: {
                        kecamatan_id: idKec,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#desa_id').html(
                            '<option value="">::Pilih Desa::</option>');
                        $.each(result, function(key, value) {
                            $("#desa_id").append('<option value="' + value
                                .id + '">' + value.desa + '</option>');
                        });
                    }
                });
            });

            $("body").on("click", ".deletePos", function() {
                var posyandu_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('posyandu-binaan.store') }}" + "/" + posyandu_id,
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
            //select all
            $(document).ready(function() {
                // Checkbox "Pilih Semua"
                $('#selectAll').click(function() {
                    $('.itemCheckbox').prop('checked', $(this).prop('checked'));
                });

                // Periksa apakah checkbox "Pilih Semua" harus dicentang
                $('.itemCheckbox').click(function() {
                    if ($('.itemCheckbox:checked').length === $('.itemCheckbox').length) {
                        $('#selectAll').prop('checked', true);
                    } else {
                        $('#selectAll').prop('checked', false);
                    }
                });
            });
        });
    </script>
@endsection
