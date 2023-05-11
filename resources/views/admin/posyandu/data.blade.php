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
                            <a href="javascript:void(0)" id="createNewPosyandu" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th>Posyandu</th>
                                        <th style="width:12%">Puskesmas</th>
                                        <th style="width:12%">Desa/Kelurahan</th>
                                        <th style="width:12%">Kecamatan</th>
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
                    <form id="posyanduForm" name="posyanduForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="posyandu_id" id="posyandu_id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Kecamatan<span class="text-danger">*</span></label>
                                <select class="browser-default custom-select select2bs4" name="kecamatan_id" id="kecamatan">
                                    <option selected disabled>::Pilih Kecamatan::</option>
                                    @foreach ($kecamatan as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Desa/Keluarahan<span class="text-danger">*</span></label>
                                <select class="browser-default custom-select select2bs4" name="desa_id" id="desa">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Puskesmas<span class="text-danger">*</span></label>
                                <select class="browser-default custom-select select2bs4" name="puskesmas_id" id="puskesmas">
                                </select>
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
                        <h6>Apakah anda yakin menghapus Posyandu ini ?</h6>
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
                ajax: "{{ route('posyandu.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "posyandu",
                        name: "posyandu",
                    },
                    {
                        data: "puskesmas",
                        name: "puskesmas",
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

            $("#createNewPosyandu").click(function() {
                $("#saveBtn").val("create-posyandu");
                $("#posyandu_id").val("");
                $("#posyanduForm").trigger("reset");
                $("#modelHeading").html("Tambah Posyandu");
                $("#ajaxModel").modal("show");
                $("#deletePos").modal("show");
            });

            $("body").on("click", ".editPos", function() {
                var posyandu_id = $(this).data("id");
                $.get("{{ route('posyandu.index') }}" + "/" + posyandu_id + "/edit", function(data) {
                    $("#modelHeading").html("Edit Posyandu");
                    $("#saveBtn").val("edit-posyandu");
                    $("#ajaxModel").modal("show");
                    $("#posyandu_id").val(data.id);
                    $("#puskesmas_id").val(data.puskesmas_id);
                    $("#desa_id").val(data.desa_id);
                    $("#kecamatan_id").val(data.kecamatan_id);
                    $("#nama_posyandu").val(data.posyandu);
                });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );

                $.ajax({
                    data: $("#posyanduForm").serialize(),
                    url: "{{ route('posyandu.store') }}",
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
                            table.draw();
                            alertSuccess("Posyandu berhasil ditambah");
                            // $('#posyanduForm').trigger("reset");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                        }
                    },
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
                        url: "{{ route('posyandu.store') }}" + "/" + posyandu_id,
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
            $(document).ready(function() {
                $('#kecamatan').on('change', function() {
                    var idKec = this.value;
                    $("#puskesmas").html('');
                    $.ajax({
                        url: "{{ route('posyandu.getpuskes') }}",
                        type: "POST",
                        data: {
                            kecamatan_id: idKec,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#puskesmas').html(
                                '<option value="">::Pilih Puskesmas::</option>');
                            $.each(result.puskesmas, function(key, value) {
                                $("#puskesmas").append('<option value="' + value
                                    .id + '">' + value.puskesmas +
                                    '</option>');
                            });
                        }
                    });
                });
                $('#kecamatan').on('change', function() {
                    var idKec = this.value;
                    $("#desa").html('');
                    $.ajax({
                        url: "{{ route('posyandu.getdesa') }}",
                        type: "POST",
                        data: {
                            kecamatan_id: idKec,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#desa').html('<option value="">::Pilih Desa::</option>');
                            $.each(result.desa, function(key, value) {
                                $("#desa").append('<option value="' + value
                                    .id + '">' + value.desa + '</option>');
                            });
                        }
                    });
                });
            });
        });
    </script>
@endsection
