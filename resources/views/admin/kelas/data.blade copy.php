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
                        <a href="javascript:void(0)" id="createNewKelas" class="btn btn-info btn-xs float-right">
                            <i class="fas fa-plus-circle"></i> Tambah</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th>Kelas</th>
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
                <form id="kelasForm" name="kelasForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="kelas_id" id="kelas_id">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Kelas<span class="text-danger"> *</span></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kelas">
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
                    <h6>Apakah anda yakin menghapus Kelas ini ?</h6>
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
            ajax: "{{ route('kelas.index') }}",
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "nama",
                    name: "nama",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ],
        });

        $("#createNewKelas").click(function() {
            $("#saveBtn").val("create-kelas");
            $("#kelas_id").val("");
            $("#jrusanForm").trigger("reset");
            $("#modelHeading").html("Tambah Kelas");
            $("#ajaxModel").modal("show");
            $("#deleteKelas").modal("show");
            $.ajax({
                url: "{{ url('kelas/get-kelas') }}",
                type: "POST",
                data: {
                    sekolah_id: {
                        {
                            Auth::user() - > sekolah_id
                        }
                    },
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#jurusan_id').html(
                        '<option value="">:::Pilih Jurusan:::</option>');
                    $.each(result, function(key, value) {
                        $("#jurusan_id").append('<option value="' + value
                            .id + '">' + value.nama + '</option>');
                    });
                }
            });
        });

        $("body").on("click", ".editKelas", function() {
            var kelas_id = $(this).data("id");
            $.get("{{ route('kelas.index') }}" + "/" + kelas_id + "/edit", function(data) {
                $("#modelHeading").html("Edit Kelas");
                $("#saveBtn").val("edit-kelas");
                $("#ajaxModel").modal("show");
                $("#kelas_id").val(data.id);
                $("#ruangan").val(data.ruangan);
                $("#nama").val(data.nama);
                $.ajax({
                    url: "{{ url('jurusan/get-jurusan') }}",
                    type: "POST",
                    data: {
                        sekolah_id: {
                            {
                                Auth::user() - > sekolah_id
                            }
                        },
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#jurusan_id').html(
                            '<option value="">:::Pilih Jurusan:::</option>');
                        $.each(result, function(key, value) {
                            $("#jurusan_id").append('<option value="' +
                                value
                                .id + '">' + value.nama + '</option>');
                            $('#jurusan_id option[value=' +
                                data.jurusan_id + ']').prop(
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
                data: $("#kelasForm").serialize(),
                url: "{{ route('kelas.store') }}",
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
                        });
                    } else {
                        table.draw();
                        alertSuccess("Kelas berhasil ditambah");
                        $("#saveBtn").html("Simpan");
                        $('#ajaxModel').modal('hide');
                    }
                },
            });
        });
        $("body").on("click", ".deleteKelas", function() {
            var kelas_id = $(this).data("id");
            $("#modelHeadingHps").html("Hapus");
            $("#ajaxModelHps").modal("show");
            $("#hapusBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                );
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('kelas.store') }}" + "/" + kelas_id,
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