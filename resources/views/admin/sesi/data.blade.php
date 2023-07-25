@extends('admin.layouts.app')

@section('content')
    @php
        $rematri = \App\Models\RematriSekolah::where('sekolah_id', Auth::user()->sekolah_id)->get();
    @endphp
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
                            <h6 class="float-left"><i class="fas fa-info-circle"></i> Sesi otomatis berakhir di akhir
                                minggu.
                            </h6>
                            <button href="javascript:void(0)" id="createNewSesi" class="btn btn-info btn-xs float-right">
                                <i class="fas fa-users"></i> Mulai</button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if (!$sesi->isEmpty())
                                    @foreach ($sesi as $item)
                                        <div class="col-sm-4 mb-3">
                                            @php
                                                $createdDate = \Carbon\Carbon::parse($item->created_at)->endOfWeek();
                                                $today = \Carbon\Carbon::now();
                                            @endphp
                                            @if ($today->lessThan($createdDate))
                                                <a href="{{ route('sesi.rematri', $item->id) }}">
                                                @else
                                                    <a href="#">
                                            @endif
                                            <div class="position-relative p-3 bg-info rounded shadow" style="height: 200px">
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
                                                        <h5>{{ $item->sekolah->sekolah }}</h5>
                                                    </div>
                                                    <div class="col-6 text-center text-sm mt-2">
                                                        Kelas : {{ $item->kelas->nama ?? '' }} -
                                                        {{ $item->ruangan->name ?? '' }}
                                                    </div>
                                                    <div class="col-6 text-center text-sm mt-2">
                                                        Sesi : {{ $item->nama }}
                                                    </div>
                                                    <div class="col-12 text-center mt-2">
                                                        <div>{{ $item->created_at->isoFormat('D MMMM Y - H:mm:s') }}</div>
                                                    </div>
                                                    <div class="col-12 text-center mt-3">
                                                        <span class="btn btn-danger btn-round btn-xs mr-2 ml-2"
                                                            id="berakhir_{{ $loop->index }}"></span>
                                                        <div id="container"></div>
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
                    <form id="sesiForm" name="sesiForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="sesi_id" id="sesi_id">
                        <small class="mb-5"><i class="fas fa-info-circle"></i> Seluruh rematri yang ada di
                            ruangan terpilih otomatis masuk kedalam sesi.
                        </small>
                        <div class="col-md-12 mt-3">
                            <x-dropdown name="kelas_id" label="Kelas">
                                @foreach ($kelas as $room)
                                    <option value="{{ $room->id }}">{{ $room->nama }}</option>
                                @endforeach
                            </x-dropdown>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Pilih Ruangan <span class="text-danger">*</span></label>
                                <select class="form-control select2 select2bs4 @error('ruangan_id') is-invalid @enderror"
                                    name="ruangan_id" id="ruangan_id" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" id="saveBtn" value="create">Buat
                                    Sesi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h6><i class="fa fa-info-circle text-danger"></i> Informasi</h6>
                    <hr>
                    <p style="text-align: justify">Ketika membuat sesi, sistem hanya menyingkronisasikan
                        <b>DATA REMATRI</b> yang saat ini tersedia. Jika sesi telah dibuat dan admin sekolah baru saja
                        menginputkan
                        <b>DATA REMATRI</b> terbaru, maka <b>DATA REMATRI</b> terbaru tersebut tidak tergabung kedalam sesi.
                        Untuk itu pastikan <b>DATA REMATRI</b> sudah terinputkan semua.
                    </p>
                    <footer class="blockquote-footer">developer diskominfo</footer>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Mengerti</button>
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
        });

        $("#saveBtn").click(function(e) {
            e.preventDefault();
            $(this).html(
                "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> membuat sesi...</i></span>"
            ).attr('disabled', 'disabled');

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
                            $("#saveBtn").html("Buat Sesi").removeAttr("disabled");
                        });
                    } else {
                        toastr.success("Sesi saved successfully.");
                        $("#saveBtn").html("Buat Sesi").removeAttr("disabled");;
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
        //waktu sesi
        // Dapatkan tanggal dari database
        var data = {!! json_encode($sesi) !!};
        // Mengakses setiap data tanggal dan jam dalam perulangan
        data.forEach(function(item, index) {
            // Ubah tanggal database menjadi objek Date
            var targetDate = new Date(item.created_at);

            // Tambahkan 7 hari ke tanggal target
            targetDate = new Date(targetDate.getFullYear(), targetDate.getMonth(), targetDate.getDate() + (6 -
                targetDate.getDay()));

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
                    // Tambahkan tombol View
                    var viewButton = document.createElement('button');
                    viewButton.className = 'btn btn-primary btn-xs ml-2 mr-2';
                    viewButton.innerHTML = '<i class="fa fa-eye"></i> View';
                    viewButton.addEventListener('click', function() {
                        var sesi_id = item.id;
                        var url = "{{ url('sesi') }}" + "/" + sesi_id +
                            "/rematri-view";
                        window.location = url;
                    });
                    countdownElement.appendChild(viewButton);

                    // Tambahkan tombol Export
                    var exportButton = document.createElement('button');
                    exportButton.className =
                        'btn btn-success btn-xs';
                    exportButton.innerHTML =
                        '<i class="fa fa-download"></i> Export';
                    exportButton.addEventListener('click',
                        function() {
                            var sesi_id = item.id;
                            var url = "{{ url('sesi') }}" + "/" + sesi_id +
                                "/export";
                            window.location = url;
                        });
                    countdownElement.appendChild(exportButton);
                }

            }, 1000);
        })
        //validasi data
        document.addEventListener('DOMContentLoaded', function() {
            var submitButton = document.getElementById('createNewSesi');
            // Cek apakah data ada atau tidak ada
            @if ($rematri->isEmpty())
                submitButton.disabled = true;
            @else
                submitButton.disabled = false;
            @endif
        });
        // Function to check if the modal has been shown before
        function hasModalBeenShown() {
            return localStorage.getItem('modalShown') === 'true';
        }

        // Function to set the modal shown flag in localStorage
        function setModalShown() {
            localStorage.setItem('modalShown', 'true');
        }

        // Function to show the modal if it has not been shown before
        function showFirstTimeModal() {
            if (!hasModalBeenShown()) {
                $('#myModal').modal('show');
                setModalShown();
            }
        }

        // Modal auto show on first page load
        window.addEventListener('DOMContentLoaded', function() {
            showFirstTimeModal();
        });

        $(document).ready(function() {
            showFirstTimeModal();
            $("#modelHeadingInfo").html("<h6><i class='fa fa-info-circle'></i> Informasi</h6>");
        });
        // Function to reset the modal shown status to false
        function resetModalShownStatus() {
            localStorage.setItem('modalShown', 'false');
        }
    </script>
@endsection
