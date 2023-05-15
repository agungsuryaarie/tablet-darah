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
                    <div class="card card-info">
                        <form method="POST" action="{{ route('rematri.store') }}" class="form-horizontal">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" placeholder="Nama">
                                        @error('nama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-7">
                                        <input type="text"
                                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                                            id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir">
                                        @error('tempat_lahir')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Tgl Lahir (dd-mm-yyyy)</label>
                                    <div class="col-sm-2">
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" id="tgl_lahir" name="tgl_lahir"
                                                class="form-control datetimepicker-input @error('tgl_lahir') is-invalid @enderror"
                                                data-target="#reservationdate">
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            @error('tgl_lahir')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nomor KK</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('nokk') is-invalid @enderror"
                                            id="nokk" name="nokk" placeholder="Nomor KK">
                                        @error('nokk')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">NIK</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                            id="nik" name="nik" placeholder="NIK">
                                        @error('nik')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Anak ke berapa?</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control @error('anak_ke') is-invalid @enderror"
                                            id="anak_ke" name="anak_ke" placeholder="Anak ke">
                                        @error('anak_ke')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Email">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Telp/HP</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('nohp') is-invalid @enderror"
                                            id="nohp" name="nohp" placeholder="Telp/HP">
                                        @error('nohp')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Agama</label>
                                    <div class="col-sm-4">
                                        <select
                                            class="form-control select2 select2bs4 @error('agama') is-invalid @enderror"
                                            id="agama" name="agama" style="width: 100%;">
                                            <option value="">:::Pilih Agama:::</option>
                                            <option value="1">Islam</option>
                                            <option value="2">Kristen </option>
                                            <option value="3">Hindu</option>
                                            <option value="4">Buddha</option>
                                            <option value="5">Khonghucu</option>
                                        </select>
                                        @error('agama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Jurusan</label>
                                    <div class="col-sm-4">
                                        <select
                                            class="form-control select2 select2bs4 @error('jurusan_id') is-invalid @enderror"
                                            name="jurusan_id" id="jurusan_id" style="width: 100%;">
                                            <option value="">:::Pilih Jurusan:::</option>
                                            @foreach ($jurusan as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('jurusan_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Kelas</label>
                                    <div class="col-sm-4">
                                        <select
                                            class="form-control select2 select2bs4 @error('kelas_id') is-invalid @enderror"
                                            name="kelas_id" id="kelas_id" style="width: 100%;">
                                        </select>
                                        @error('kelas_id')
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
                                            id="berat_badan" name="berat_badan" placeholder="Berat Badan">
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
                                            id="panjang_badan" name="panjang_badan" placeholder="Tinggi badan">
                                        @error('panjang_badan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">HB<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control @error('hb') is-invalid @enderror"
                                            id="hb" name="hb" placeholder="HB">
                                        @error('hb')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nama Orang Tua<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text"
                                            class="form-control @error('nama_ortu') is-invalid @enderror" id="nama_ortu"
                                            name="nama_ortu" placeholder="Nama Orang Tua">
                                        @error('nama_ortu')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nik Orang Tua<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text"
                                            class="form-control @error('nik_ortu') is-invalid @enderror" id="nik_ortu"
                                            name="nik_ortu" placeholder="Nik Orang Tua">
                                        @error('nik_ortu')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Telp/Hp Orang Tua<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text"
                                            class="form-control @error('tlp_ortu') is-invalid @enderror" id="tlp_ortu"
                                            name="tlp_ortu" placeholder="Telp/Hp Orang Tua">
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
                                                <option value="{{ $item->id }}">
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
                                            placeholder="Enter ..."></textarea>
                                        @error('alamat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Simpan</button>
                                <button type="submit" class="btn btn-default">Cancel</button>
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
        $('#jurusan_id').on('change', function() {
            var idJurusan = this.value;
            $("#kelas_id").html('');
            $.ajax({
                url: "{{ url('rematri/get-kelas') }}",
                type: "POST",
                data: {
                    jurusan_id: idJurusan,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#kelas_id').html('<option value="">:::Pilih Kelas:::</option>');
                    $.each(result.kelas, function(key, value) {
                        $("#kelas_id").append('<option value="' + value
                            .id + '">' + value.nama + " " + value.jurusan.nama + " " +
                            value.ruangan + '</option>');
                    });
                }
            });
        });

        $('#kecamatan_id').on('change', function() {
            var idKecamatan = this.value;
            $("#desa_id").html('');
            $.ajax({
                url: "{{ url('rematri/get-desa') }}",
                type: "POST",
                data: {
                    kecamatan_id: idKecamatan,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#desa_id').html('<option value="">:::Pilih Desa/Kelurahan:::</option>');
                    $.each(result.desa, function(key, value) {
                        $("#desa_id").append('<option value="' + value
                            .id + '">' + value.desa + '</option>');
                    });
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
