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
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Anak ke berapa?</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="" placeholder="Anak ke">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id=""
                                            placeholder="Tempat Lahir">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Tgl Lahir (dd-mm-yyyy)</label>
                                    <div class="col-sm-2">
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                data-target="#reservationdate">
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nomor KK</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="" placeholder="Nomor KK">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">NIK</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="" placeholder="NIK">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="" placeholder="Nama">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-3">
                                        <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Telp/HP</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="" placeholder="Telp/HP">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Agama</label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2 select2bs4" style="width: 100%;">
                                            <option selected="selected">:::Pilih Agama:::</option>
                                            <option value="1">Islam</option>
                                            <option value="2">Kristen </option>
                                            <option value="3">Hindu</option>
                                            <option value="4">Buddha</option>
                                            <option value="5">Khonghucu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Jurusan</label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2 select2bs4" name="jurusan_id" id="jurusan_id"
                                            style="width: 100%;">
                                            <option selected="selected">:::Pilih Jurusan:::</option>
                                            @foreach ($jurusan as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Kelas</label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2 select2bs4" name="kelas_id" id="kelas_id"
                                            style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Berat Badan (kg)<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id=""
                                            placeholder="Berat Badan">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Tinggi badan (cm)<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id=""
                                            placeholder="Tinggi badan">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">HB<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="" placeholder="HB">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nama Orang Tua<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id=""
                                            placeholder="Nama Orang Tua">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Nik Orang Tua<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id=""
                                            placeholder="Nik Orang Tua">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Telp/Hp Orang Tua<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id=""
                                            placeholder="Telp/Hp Orang Tua">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Kecamatan<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2 select2bs4" name="kecamatan_id"
                                            id="kecamatan_id" style="width: 100%;">
                                            <option selected="selected">:::Pilih Kecamatan:::</option>
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->kecamatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Desa/Kelurahan<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <select class="form-control select2 select2bs4" name="desa_id" id="desa_id"
                                            style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-2 col-form-label">Alamat Lengkap<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
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
