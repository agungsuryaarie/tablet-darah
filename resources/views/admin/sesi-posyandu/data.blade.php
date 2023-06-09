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
                            <h6 class="float-left"><i class="fas fa-info-circle"></i> Sesi otomatis berakhir 1 minggu
                                setelah sesi dibuat.
                            </h6>
                            <a href="javascript:void(0)" id="createNewSesiP" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-plus-circle"></i> Tambah</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if (!$sesip->isEmpty())
                                    @foreach ($sesip as $item)
                                        <div class="col-sm-4 mb-3">
                                            @php
                                                $createdDate = \Carbon\Carbon::parse($item->created_at)->addWeek();
                                                $today = \Carbon\Carbon::now();
                                            @endphp
                                            @if ($today->lessThan($createdDate))
                                                <a
                                                    href="{{ route('sesi.posyandu.rematri', Crypt::encryptString($item->id)) }}">
                                                @else
                                                    <a href="#" class="SesiError">
                                            @endif
                                            <div class="position-relative p-3 bg-info rounded" style="height: 180px">
                                                @if ($today->lessThan($createdDate))
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
                                                        <h5>{{ $item->posyandu->posyandu }}</h5>
                                                    </div>
                                                    <div class="col-12 text-center text-sm mt-2">
                                                        Sesi : {{ $item->nama }}
                                                    </div>
                                                    <div class="col-12 text-center mt-2">
                                                        <div>{{ $item->created_at->isoFormat('D MMMM Y - H:mm:s') }}</div>
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
                    <form id="sesipForm" name="sesipForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="sesip_id" id="sesip_id">
                        <small class="float-left mb-3"><i class="fas fa-info-circle"></i> Seluruh rematri yang ada di
                            Posyandu
                            otomatis masuk kedalam sesi.
                        </small>
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
        $("#createNewSesiP").click(function() {
            $("#saveBtn").val("create-sesi-posyandu");
            $("#sesip_id").val("");
            $("#sesiForm").trigger("reset");
            $("#modelHeading").html("Tambah Sesi Posyandu");
            $("#ajaxModel").modal("show");
            $("#deleteSesiP").modal("show");
        });

        $("#saveBtn").click(function(e) {
            e.preventDefault();
            $(this).html(
                "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
            );

            $.ajax({
                data: $("#sesipForm").serialize(),
                url: "{{ route('sesi-posyandu.store') }}",
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
                        toastr.success("Sesi Posyandu saved successfully.");
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
        // Dapatkan tanggal dari database
        var data = {!! json_encode($sesip) !!};
        // Mengakses setiap data tanggal dan jam dalam perulangan
        data.forEach(function(item, index) {

            // Ubah tanggal database menjadi objek Date
            var targetDate = new Date(item.created_at);

            // Tambahkan 7 hari ke tanggal target
            targetDate.setDate(targetDate.getDate() + 7);

            // Hitung selisih waktu antara tanggal target dan tanggal saat ini
            var timeDiff = targetDate.getTime() - new Date().getTime();

            // Hitung jumlah hari, jam, menit, dan detik yang tersisa
            var days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            var hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

            // Tampilkan countdown pada elemen HTML
            document.getElementById('berakhir_' + index).innerHTML = days + " hari, " + hours + " jam, " + minutes +
                " menit, " +
                seconds + " detik";

            if (timeDiff < 0) {
                var countdownElement = document.getElementById('berakhir_' + index);
                countdownElement.innerHTML = "sesi berakhir";
            }

            // Update berakhir setiap detik
            setInterval(function() {
                timeDiff = targetDate.getTime() - new Date().getTime();
                days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                document.getElementById('berakhir_' + index).innerHTML = days + " hari, " + hours +
                    " jam, " +
                    minutes +
                    " menit, " + seconds + " detik";

                if (timeDiff < 0) {
                    var countdownElement = document.getElementById('berakhir_' + index);
                    countdownElement.innerHTML = "sesi berakhir";
                }

            }, 1000);
        })
    </script>
@endsection
