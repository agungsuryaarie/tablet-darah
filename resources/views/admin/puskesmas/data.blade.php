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
                            <a href="javascript:void(0)" id="createNewPuskesmas" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:12%">Kode Puskesmas</th>
                                        <th>Puskesmas</th>
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
                    <form id="puskesmasForm" name="puskesmasForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="puskesmas_id" id="puskesmas_id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Kecamatan<span class="text-danger">*</span></label>
                                <select class="browser-default custom-select select2bs4" name="kecamatan_id"
                                    id="kecamatan_id">
                                    {{-- <option selected disabled>::Pilih Kecamatan::</option>
                                    @foreach ($kecamatan as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->kecamatan }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kode Puskesmas<span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="kode_puskesmas" name="kode_puskesmas"
                                    placeholder="Kode Puskesmas">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Puskesmas<span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_puskesmas" name="nama_puskesmas"
                                    placeholder="Nama Puskesmas">
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
                        <h6>Apakah anda yakin menghapus Puskesmas ini ?</h6>
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
                ajax: "{{ route('puskesmas.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "kode_puskesmas",
                        name: "kode_puskesmas",
                    },
                    {
                        data: "puskesmas",
                        name: "puskesmas",
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

            $("#createNewPuskesmas").click(function() {
                $("#saveBtn").val("create-puskesmas");
                $("#puskesmas_id").val("");
                $("#puskesmasForm").trigger("reset");
                $("#modelHeading").html("Tambah Puskesmas");
                $("#ajaxModel").modal("show");
                $("#deletePuskes").modal("show");
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
            });

            $("body").on("click", ".editPuskes", function() {
                var puskesmas_id = $(this).data("id");
                $.get("{{ route('puskesmas.index') }}" + "/" + puskesmas_id + "/edit", function(data) {
                    $("#modelHeading").html("Edit Puskesmas");
                    $("#saveBtn").val("edit-puskesmas");
                    $("#ajaxModel").modal("show");
                    $("#puskesmas_id").val(data.id);
                    // $("#kecamatan_id").val(data.kecamatan_id);
                    $("#kode_puskesmas").val(data.kode_puskesmas);
                    $("#nama_puskesmas").val(data.puskesmas);
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
                });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );

                $.ajax({
                    data: $("#puskesmasForm").serialize(),
                    url: "{{ route('puskesmas.store') }}",
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
                                // $('#puskesmasForm').trigger("reset");
                            });
                        } else {
                            table.draw();
                            alertSuccess("Puskesmas berhasil ditambah");
                            // $('#puskesmasForm').trigger("reset");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deletePuskes", function() {
                var puskesmas_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('puskesmas.store') }}" + "/" + puskesmas_id,
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
