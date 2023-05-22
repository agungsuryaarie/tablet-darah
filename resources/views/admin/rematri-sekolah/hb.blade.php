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
                        <li class="breadcrumb-item"><a href="{{ route('rematri.index') }}">Data Rematri</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="invoice p-3 mb-3">
                        <div class="col-sm-4 invoice-col mt-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="width: 15%">NIK</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 40%">{{ $rematri->nik }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td>{{ $rematri->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <td>{{ $rematri->kelas->nama }} {{ $rematri->jurusan->nama }}
                                            {{ $rematri->kelas->ruangan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Umur</td>
                                        <td>:</td>
                                        <td>
                                            <?php $tanggal_lahir = date('Y-m-d', strtotime($rematri->tgl_lahir));
                                            $birthDate = new \DateTime($tanggal_lahir);
                                            $today = new \DateTime('today');
                                            if ($birthDate > $today) {
                                                return '0 Tahun 0 Bulan 0 Hari';
                                            }
                                            $y = $today->diff($birthDate)->y;
                                            // dd($y);
                                            $m = $today->diff($birthDate)->m;
                                            $d = $today->diff($birthDate)->d;
                                            echo $y . ' Tahun ' . ' - ' . $m . ' Bulan ' . ' - ' . $d . ' Hari'; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mb-5">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Daftar Pengecekan HB
                                        <a href="javascript:void(0)" id="createNewHB"
                                            class="btn btn-info btn-xs float-right">
                                            <i class="fas fa-plus-circle"></i> Tambah</a>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped data-table">
                                        <thead>
                                            <tr>
                                                <th style="width:5%">No</th>
                                                <th style="width:15%">Tgl Pengecekan</th>
                                                <th class="text-center">
                                                    Berat Badan
                                                </th>
                                                <th class="text-center">
                                                    Panjang Badan
                                                </th>
                                                <th class="text-center" style="width: 10%">
                                                    HB
                                                </th>
                                                <th class="text-center" style="width: 8%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('modal')
    {{-- Modal HB --}}
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
                    <form id="hbForm" name="hbForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="hb_id" id="hb_id">
                        <input type="hidden" name="rematri_id" value="{{ $rematri->id }}">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="text" class="col-sm-8 control-label">Tgl Pengecekan<span
                                        class="text-danger">
                                        *</span></label>
                                <div class="col-sm-12">
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" id="tgl_cek" name="tgl_cek"
                                            class="form-control datetimepicker-input @error('tgl_cek') is-invalid @enderror"
                                            data-target="#reservationdate">
                                        <div class="input-group-append" data-target="#reservationdate"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        @error('tgl_cek')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Berat Badan<span class="text-danger">
                                        *</span></label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" id="berat_badan" name="berat_badan"
                                        placeholder="Contoh : 50">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Panjang Badan<span class="text-danger">
                                        *</span></label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" id="panjang_badan" name="panjang_badan"
                                        placeholder="Contoh : 150">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">HB<span class="text-danger">
                                        *</span></label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" id="hb" name="hb"
                                        placeholder="Contoh : 10">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm" id="saveBtn"
                                        value="create">Simpan
                                    </button>
                                </div>
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
                        <h6>Apakah anda yakin menghapus Data HB ini ?</h6>
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
                ajax: "{{ route('rematri.hb', $rematri->id) }}",
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                    },
                    {
                        data: "tgl_cek",
                        name: "tgl_cek",
                    },
                    {
                        data: "berat_badan",
                        name: "berat_badan",
                    },
                    {
                        data: "panjang_badan",
                        name: "panjang_badan",
                    },
                    {
                        data: "hb",
                        name: "hb",
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
            });

            $("#createNewHB").click(function() {
                $("#saveBtn").val("create-hb");
                $("#hb_id").val("");
                $("#hbForm").trigger("reset");
                $("#modelHeading").html("Tambah HB");
                $("#ajaxModel").modal("show");
                $("#deleteHB").modal("show");
            });
            $("#saveBtn").click(function(e) {
                e.preventDefault();
                $(this).html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
                );

                $.ajax({
                    data: $("#hbForm").serialize(),
                    url: "{{ route('hb.store') }}",
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
                            alertSuccess("HB berhasil ditambah");
                            $("#saveBtn").html("Simpan");
                            $('#ajaxModel').modal('hide');
                        }
                    },
                });
            });
            $("body").on("click", ".deleteHB", function() {
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
                            "/destroyhb",
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
            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });
        });
    </script>
@endsection
