@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="naikForm" name="naikForm" method="post" class="form-horizontal">
                @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="col-md-12">
                            <div class="alert alert-dismissible fade show" role="alert" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <small class="mb-5"><i class="fas fa-info-circle text-danger"></i>Untuk lebih mudah kenaikan
                                kelas, Silahkan filter Rematri berdasarkan kelasnya masing-masing.
                            </small>
                            <hr>
                            <div class="row justify-content-center">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Filter Kelas<span class="text-danger">*</span></label>
                                        <select data-column="5" id="kelas_filter_id" class="form-control select2bs4 filter">
                                            <option selected disabled>:::Filter Kelas:::</option>
                                            <option value="">Semua</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Pilih Kelas<span class="text-danger">*</span></label>
                                        <select name="kelas_id" id="kelas_id"
                                            class="form-control select2bs4  @error('kelas_id') is-invalid @enderror"">
                                            <option selected disabled>:::Pilih Kelas:::</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kelas_id')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Pilih Ruangan<span class="text-danger">*</span></label>
                                        <select name="ruangan_id" id="ruangan_id"
                                            class="form-control select2bs4  @error('ruangan_id') is-invalid @enderror"">
                                        </select>
                                        @error('ruangan_id')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4 p-2">
                                    <div class="form-group">
                                        <button class="btn btn-primary" id="up"><i class="fa fa-arrow-up"></i>
                                            Naikkan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%"><input type="checkbox" id="selectAll">
                                        </th>
                                        <th class="text-center" style="width:3%">No</th>
                                        <th style="width:10%">NIK</th>
                                        <th>Nama</th>
                                        <th style="width:12%">Tanggal Lahir</th>
                                        <th class="text-center" style="width:5%">Kelas</th>
                                        <th class="text-center" style="width:8%">Ruangan</th>
                                        <th style="width:25%">Nama Orang Tua</th>
                                        <th class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
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
                        <h6>Apakah anda yakin menghapus Data Rematri ini ?</h6>
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
                ajax: "{{ route('rematri.index') }}",
                columns: [{
                        data: "checkbox",
                        name: "checkbox",
                        orderable: false,
                        searchable: false,
                    }, {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "nik",
                        name: "nik",
                    },
                    {
                        data: "nama",
                        name: "nama",
                    },
                    {
                        data: "tgl_lahir",
                        name: "tgl_lahir",
                    },
                    {
                        data: "kelas",
                        name: "kelas",
                    },
                    {
                        data: "ruangan",
                        name: "ruangan",
                    },
                    {
                        data: "nama_ortu",
                        name: "nama_ortu",
                    },

                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });
            $('#kelas_id').on('change', function() {
                var idKelas = this.value;
                $("#ruangan_id").html('');
                $.ajax({
                    url: "{{ url('ruangan/get-ruangan') }}",
                    type: "POST",
                    data: {
                        kelas_id: idKelas,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        if (result.length == 0) {
                            $('#ruangan_id').html(
                                '<option value="">:::Tidak ada ruangan:::</option>');
                        } else {
                            $('#ruangan_id').html(
                                '<option value="">:::Pilih Ruangan:::</option>');
                            $.each(result, function(key, value) {
                                $("#ruangan_id").append('<option value="' + value
                                    .id + '">Ruangan - ' + value.name + '</option>');
                            });
                        }
                    }
                });
            });

            $("body").on("click", ".editRematri", function() {
                var rematri_id = $(this).data("id");
                var url = "{{ url('rematri/edit') }}" + "/" + rematri_id;
                window.location = url;
            });
            $("body").on("click", ".hbRematri", function() {
                var rematri_id = $(this).data("id");
                var url = "{{ url('rematri') }}" + "/" + rematri_id + "/hb";
                window.location = url;
            });

            $("body").on("click", ".deleteRematri", function() {
                var rematri_id = $(this).data("id");
                $("#modelHeadingHps").html("Hapus");
                $("#ajaxModelHps").modal("show");
                $("#hapusBtn").click(function(e) {
                    e.preventDefault();
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>"
                    );
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('rematri') }}" + "/" + rematri_id +
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
                                toastr.success(data.success);
                                $("#hapusBtn").html(
                                    "<i class='fa fa-trash'></i>Hapus");
                                $('#ajaxModelHps').modal('hide');
                            }
                        },
                    });
                });
            });
            $("#up").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> sedang diproses...</i></span>"
                ).attr('disabled', 'disabled');
                $.ajax({
                    data: $("#naikForm").serialize(),
                    url: "{{ route('kenaikan-kelas.naik') }}",
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        $('#selectAll').prop('checked', false);
                        if (data.errors) {
                            $('.alert-danger').html('');
                            $.each(data.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' +
                                    value +
                                    '</li></strong>');
                                $(".alert-danger").fadeOut(5000);
                                $("#up").html(
                                        "<i class='fa fa-arrow-up'></i> Naikkan")
                                    .removeAttr("disabled");
                            });
                        } else {
                            table.draw();
                            toastr.success(data.success);
                            $("#up").html("<i class='fa fa-arrow-up'></i> Naikkan").removeAttr(
                                "disabled");
                        }
                    },
                });
            });
            $('.filter').change(function() {
                table.column($(this).data('column'))
                    .search($(this).val())
                    .draw();
            });
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
