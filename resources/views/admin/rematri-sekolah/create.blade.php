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
    @if (!$rematri || !$rematri->isFilled())
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-center text-danger font-weight-bold"><i class="fa fa-info-circle"></i> UNTUK MEMULAI
                        SESI,
                        SILAHKAN TAMBAHKAN REMATRI
                        TERLEBIH DAHULU
                    </h6>
                </div>
            </div>
        </div>
    @endif
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <form method="POST" action="{{ route('rematri.store') }}" class="form-horizontal">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nama<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" placeholder="Nama" value="{{ old('nama') }}">
                                        @error('nama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Tempat Lahir<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-7">
                                        <textarea type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir"
                                            name="tempat_lahir" rows="3" placeholder="Enter ...">{{ old('tempat_lahir') }}</textarea>
                                        @error('tempat_lahir')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Tgl Lahir (dd-mm-yyyy)<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" id="tgl_lahir" name="tgl_lahir"
                                                class="form-control datetimepicker-input @error('tgl_lahir') is-invalid @enderror"
                                                data-target="#reservationdate" value="{{ old('tgl_lahir') }}">
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('tgl_lahir')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nomor KK<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('nokk') is-invalid @enderror"
                                            id="nokk" name="nokk" placeholder="Nomor KK"
                                            value="{{ old('nokk') }}">
                                        @error('nokk')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">NIK<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                            id="nik" name="nik" placeholder="NIK" value="{{ old('nik') }}">
                                        @error('nik')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Anak ke berapa?<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control @error('anak_ke') is-invalid @enderror"
                                            id="anak_ke" name="anak_ke" placeholder="Anak ke"
                                            value="{{ old('anak_ke') }}">
                                        @error('anak_ke')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email<small>
                                            (Opsional)</small></label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Telp/HP<small>
                                            (Opsional)</small></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control @error('nohp') is-invalid @enderror"
                                            id="nohp" name="nohp" placeholder="Telp/HP"
                                            value="{{ old('nohp') }}">
                                        @error('nohp')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Agama<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <select
                                            class="form-control select2 select2bs4 @error('agama') is-invalid @enderror"
                                            id="agama" name="agama" style="width: 100%;">
                                            <option value="">:::Pilih Agama:::</option>
                                            <option value="1" {{ old('agama') == '1' ? 'selected' : '' }}>
                                                Islam</option>
                                            <option value="2" {{ old('agama') == '2' ? 'selected' : '' }}>Kristen
                                            </option>
                                            <option value="3" {{ old('agama') == '3' ? 'selected' : '' }}>Hindu
                                            </option>
                                            <option value="4" {{ old('agama') == '4' ? 'selected' : '' }}>Buddha
                                            </option>
                                            <option value="5" {{ old('agama') == '5' ? 'selected' : '' }}>Khonghucu
                                            </option>
                                            <option value="6" {{ old('agama') == '6' ? 'selected' : '' }}>Katolik
                                            </option>
                                        </select>
                                        @error('agama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Kelas<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <select
                                            class="form-control select2 select2bs4 @error('kelas_id') is-invalid @enderror"
                                            name="kelas_id" id="kelas_id" style="width: 100%;">
                                            <option value="">:::Pilih Kelas:::</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kelas_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Ruangan</label>
                                    <div class="col-sm-4">
                                        <select
                                            class="form-control select2 select2bs4 @error('ruangan_id') is-invalid @enderror"
                                            name="ruangan_id" id="ruangan_id" style="width: 100%;">
                                        </select>
                                        @error('ruangan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Berat Badan (kg)<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text"
                                            class="form-control @error('berat_badan') is-invalid @enderror"
                                            id="berat_badan" name="berat_badan" placeholder="Berat Badan"
                                            value="{{ old('berat_badan') }}">
                                        @error('berat_badan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Tinggi badan (cm)<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text"
                                            class="form-control @error('panjang_badan') is-invalid @enderror"
                                            id="panjang_badan" name="panjang_badan" placeholder="Tinggi badan"
                                            value="{{ old('panjang_badan') }}">
                                        @error('panjang_badan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nama Orang Tua<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text"
                                            class="form-control @error('nama_ortu') is-invalid @enderror" id="nama_ortu"
                                            name="nama_ortu" placeholder="Nama Orang Tua"
                                            value="{{ old('nama_ortu') }}">
                                        @error('nama_ortu')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">NIK Orang Tua<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text"
                                            class="form-control @error('nik_ortu') is-invalid @enderror" id="nik_ortu"
                                            name="nik_ortu" placeholder="NIK Orang Tua" value="{{ old('nik_ortu') }}">
                                        @error('nik_ortu')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Telp/Hp Orang Tua<small>
                                            (Opsional)</small></label>
                                    <div class="col-sm-2">
                                        <input type="text"
                                            class="form-control @error('tlp_ortu') is-invalid @enderror" id="tlp_ortu"
                                            name="tlp_ortu" placeholder="Telp/Hp Orang Tua"
                                            value="{{ old('tlp_ortu') }}">
                                        @error('tlp_ortu')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Kecamatan<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <select
                                            class="form-control select2 select2bs4 @error('kecamatan_id') is-invalid @enderror"
                                            name="kecamatan_id" id="kecamatan_id" style="width: 100%;">
                                            <option value="">:::Pilih Kecamatan:::</option>
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('kecamatan_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->kecamatan }}</option>
                                            @endforeach
                                        </select>
                                        @error('kecamatan_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Desa/Kelurahan<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <select
                                            class="form-control select2 select2bs4 @error('desa_id') is-invalid @enderror"
                                            name="desa_id" id="desa_id" style="width: 100%;">
                                        </select>
                                        @error('desa_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Alamat Lengkap<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" rows="3" id="alamat" name="alamat"
                                            placeholder="Enter ...">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Simpan</button>
                                <a href="{{ route('rematri.index') }}" class="btn btn-default">Batal</a>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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
                        $('#ruangan_id').html('<option value="">:::Tidak ada ruangan:::</option>');
                    } else {
                        $('#ruangan_id').html('<option value="">:::Pilih Ruangan:::</option>');
                        $.each(result, function(key, value) {
                            $("#ruangan_id").append('<option value="' + value
                                .id + '">Ruangan - ' + value.name + '</option>');
                        });
                    }
                }
            });
        });

        $('#kecamatan_id').on('change', function() {
            var idKecamatan = this.value;
            $("#desa_id").html('');
            $.ajax({
                url: "{{ url('desa/get-desa') }}",
                type: "POST",
                data: {
                    kecamatan_id: idKecamatan,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    if (result == "") {
                        $('#desa_id').html(
                            '<option value="">----Data Desa Kosong----</option>'
                        );
                    } else {
                        $('#desa_id').html(
                            '<option value="">:::Pilih Desa/Kelurahan:::</option>');
                        $.each(result, function(key, value) {
                            $("#desa_id").append('<option value="' + value
                                .id + '">' + value.desa + '</option>');
                        });
                    }
                }
            });
        });

        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });
        })
    </script>
@endsection
