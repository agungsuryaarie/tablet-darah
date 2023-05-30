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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="float-left"><i class="fas fa-info-circle"></i> Sesi berakhir setiap jam 12 malam
                                sejak sesi dibuat.
                            </h6>
                            <a href="javascript:void(0)" id="createNewSesi" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if (!$sesi->isEmpty())
                                    @foreach ($sesi as $item)
                                        <div class="col-sm-4 mb-3">
                                            @if (date('Y-m-d') < $item->created_at)
                                                <a href="{{ route('sesi.rematri', Crypt::encryptString($item->id)) }}">
                                                @else
                                                    <a href="#" class="SesiError">
                                            @endif
                                            <div class="position-relative p-3 bg-blue rounded" style="height: 180px">
                                                @if (date('Y-m-d') < $item->created_at)
                                                    <div class="ribbon-wrapper ribbon-lg">
                                                        <div class="ribbon bg-success">
                                                            Berlangsung
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="ribbon-wrapper ribbon-lg">
                                                        <div class="ribbon bg-danger">
                                                            Berakhir
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row p-3">
                                                    <div class="col-12 text-center">
                                                        <h5>{{ $item->sekolah->sekolah }}</h5>
                                                    </div>
                                                    <div class="col-6 text-center text-sm mt-2">
                                                        Kelas :
                                                        @if ($item->jurusan_id == null)
                                                            {{ $item->kelas->nama }}
                                                        @else
                                                            {{ $item->kelas->nama }} {{ $item->jurusan->nama }}
                                                            {{ $item->jurusan->ruangan }}
                                                        @endif
                                                    </div>
                                                    <div class="col-6 text-center text-sm mt-2">
                                                        Sesi : {{ $item->nama }}
                                                    </div>
                                                    <div class="col-12 text-center mt-2">
                                                        <div>{{ $item->created_at->isoFormat('D MMMM Y') }}</div>
                                                    </div>
                                                    <div class="col-12 text-center mt-2">
                                                        <span class="btn btn-danger btn-round btn-xs mr-2 ml-2"
                                                            id="berakhir_{{ $loop->index }}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card-body text-center">
                                        <h6><i class="text-danger fa fa-info-circle"></i>&nbsp;Sesi tidak ditemukan . . .
                                        </h6>
                                    </div>
                                @endif
                            </div>
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
                    <form id="sesiForm" name="sesiForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="sesi_id" id="sesi_id">
                        <small class="mb-5"><i class="fas fa-info-circle"></i> Seluruh rematri yang ada di
                            kelas terpilih otomatis masuk kedalam sesi.
                        </small>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Kelas<span class="text-danger">*</span></label>
                                <select class="form-control select2 select2bs4 @error('kelas_id') is-invalid @enderror"
                                    name="kelas_id" id="kelas_id" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        @if (Auth::user()->jenjang == 'SMA' or Auth::user()->jenjang == 'SMK')
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Jurusan<span class="text-danger">*</span></label>
                                    <select class="browser-default custom-select select2bs4" name="jurusan_id"
                                        id="jurusan_id">
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nama Sesi<span class="text-danger"> *</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="contoh : Januari 1 / Januari Minggu ke 1">
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

@section('script')
    <script>
        $("#createNewSesi").click(function() {
            $("#saveBtn").val("create-sesi-sekolah");
            $("#sesi_id").val("");
            $("#sesiForm").trigger("reset");
            $("#modelHeading").html("Tambah Sesi");
            $("#ajaxModel").modal("show");
            $("#deleteSesi").modal("show");
            $.ajax({
                url: "{{ url('kelas/get-kelas') }}",
                type: "POST",
                data: {
                    sekolah_id: {{ Auth::user()->sekolah_id }},
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#kelas_id').html(
                        '<option value="">:::Pilih Kelas:::</option>');
                    $.each(result, function(key, value) {
                        $("#kelas_id").append('<option value="' + value
                            .id + '">' + value.nama + '</option>');
                    });
                }
            });
        });

        $(document).ready(function() {
            $('#kelas_id').on('change', function() {
                var idKelas = this.value;
                $("#jurusan_id").html('');
                $.ajax({
                    url: "{{ url('jurusan/get-jurusan') }}",
                    type: "POST",
                    data: {
                        kelas_id: idKelas,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#jurusan_id').html(
                            '<option value="">::Pilih Jurusan::</option>'
                        );
                        $.each(result, function(key, value) {
                            $("#jurusan_id").append(
                                '<option value="' + value
                                .id + '">' + value
                                .kelas.nama + ' ' + value.nama + ' ' + value
                                .ruangan +
                                '</option>');
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
                data: $("#sesiForm").serialize(),
                url: "{{ route('sesi.store') }}",
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
                        alertSuccess("Sesi saved successfully.");
                        $("#saveBtn").html("Simpan");
                        $('#ajaxModel').modal('hide');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                },
            });
        });
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('.SesiError').click(function() {
            toastr.error('Sesi sudah berakhir.')
        });

        //waktu sesi
        var data = {!! json_encode($sesi) !!};
        // Fungsi countdown
        function countdown() {
            // Mendapatkan tanggal dan jam saat ini
            var now = new Date();

            // Mengakses setiap data tanggal dan jam dalam perulangan
            data.forEach(function(item, index) {
                var targetDate = new Date(item.created_at);

                // Menentukan target waktu tengah malam (jam 00:00)
                var targetMidnight = new Date(targetDate.getFullYear(), targetDate.getMonth(), targetDate
                    .getDate() + 1,
                    0, 0, 0);

                // Menghitung selisih waktu antara sekarang dan tengah malam
                var timeDiff = targetMidnight - now;

                // Menghitung selisih waktu dalam satuan jam, menit, dan detik
                var hours = Math.floor(timeDiff / (1000 * 60 * 60));
                var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                // Menampilkan countdown pada elemen HTML
                var countdownElement = document.getElementById('berakhir_' + index);
                countdownElement.innerHTML = hours + ' jam, ' + minutes + ' menit, ' + seconds + ' detik';

                if (timeDiff < 0) {
                    var countdownElement = document.getElementById('berakhir_' + index);
                    countdownElement.innerHTML = "sesi berakhir";
                }
            });
        }

        // Memanggil fungsi countdown setiap detik
        setInterval(countdown, 1000);
    </script>
@endsection
