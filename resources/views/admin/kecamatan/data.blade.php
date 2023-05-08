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
                            <a href="javascript:void(0)" id="createNewKecamatan" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:15%">Kode Wilayah</th>
                                        <th>Kecamatan</th>
                                        <th style="width:20%">Kabupaten</th>
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
                    <form id="kecamatanForm" name="kecamatanForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="kecamatan_id" id="kecamatan_id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label>Kabupaten<span class="text-danger">*</span></label>
                                <select class="browser-default custom-select select2bs4" name="kabupaten_id"
                                    id="kabupaten_id">
                                    <option selected disabled>::Pilih Kabupaten::</option>
                                    @foreach ($kabupaten as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->kabupaten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kode Wilayah<span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="kode_wilayah" name="kode_wilayah"
                                    placeholder="Kode Wilayah" onkeypress="return hanyaAngka(event)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Kecamatan<span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_kecamatan" name="nama_kecamatan"
                                    placeholder="Nama Kecamatan">
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
                        <h6>Apakah anda yakin menghapus Kecamatan ini ?</h6>
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
                ajax: "{{ route('kecamatan.index') }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "kode_wilayah",
                        name: "kode_wilayah",
                    },
                    {
                        data: "kecamatan",
                        name: "kecamatan",
                    },
                    {
                        data: "kabupaten",
                        name: "kabupaten",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $("#createNewKecamatan").click(function() {
                $("#saveBtn").val("create-kecamatan");
                $("#kecamatan_id").val("");
                $("#kecamatanForm").trigger("reset");
                $("#modelHeading").html("Tambah Kecamatan");
                $("#ajaxModel").modal("show");
                $("#deleteKec").modal("show");
            });

            $("body").on("click", ".editKec", function() {
                var kecamatan_id = $(this).data("id");
                $.get("{{ route('kecamatan.index') }}" + "/" + kecamatan_id + "/edit", function(data) {
                    $("#modelHeading").html("Edit Kecamatan");
                    $("#saveBtn").val("edit-kecamatan");
                    $("#ajaxModel").modal("show");
                    $("#kecamatan_id").val(data.id);
                    $("#kabupaten_id").val(data.kabupaten_id);
                    $("#kode_wilayah").val(data.kode_wilayah);
                    $("#nama_kecamatan").val(data.kecamatan);
                });
            });

            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );

                $.ajax({
                    data: $("#kecamatanForm").serialize(),
                    url: "{{ route('kecamatan.store') }}",
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
                                // $('#kecamatanForm').trigger("reset");
                            });
                        } else {
                            table.draw();
                            alertSuccess("Kecamatan berhasil ditambah");
                            // $('#kecamatanForm').trigger("reset");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deleteKec", function() {
                var kecamatan_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('kecamatan.store') }}" + "/" + kecamatan_id,
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
