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
                        <li class="breadcrumb-item"><a
                                href="{{ route('sesi.posyandu.rematri', Crypt::encryptString($sesip->id)) }}">Detail Sesi</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('sesi.posyandu.uploadfoto') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="col-md-4" style="text-align: center">
                                <img src="{{ url('storage/foto-sesi-posyandu/blank.png') }}" alt="Image Profile"
                                    class="img-thumbnail rounded img-preview" width="120px">
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="posyandu_id" value="{{ $sesip->posyandu_id }}">
                                        <input type="hidden" name="sesip_id" value="{{ $sesip->id }}">
                                        <input type="hidden" name="rematrip_id" value="{{ $rematrip->id }}">
                                        <input type="hidden" name="ttd_posyandu_id" value="{{ $sesipfoto->id }}">
                                        <div class="custom-file">
                                            <input type="file" id="foto" name="foto" class="custom-file-input"
                                                id="foto" onchange="previewImg();" accept=".png, .jpg, .jpeg" required>
                                            <label class="custom-file-label">Pilih File</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" style="margin-top:10px"><i
                                            class="fa fa-upload"></i> Upload</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@endsection
@section('script')
    <script>
        function previewImg() {
            const foto = document.querySelector('#foto');
            const img = document.querySelector('.img-preview');

            const fileFoto = new FileReader();
            fileFoto.readAsDataURL(foto.files[0]);

            fileFoto.onload = function(e) {
                img.src = e.target.result;
            }
        }
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
