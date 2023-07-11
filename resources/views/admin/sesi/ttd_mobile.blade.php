@extends('admin.layouts.app')

@section('content')
    <x-header menu="{{ $menu }}"></x-header>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('sesi.uploadfoto') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="col-md-4" style="text-align: center">
                                <img id="preview-image-before-upload" src="{{ url('teen.png') }}" alt="preview image"
                                    width="250px">
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="kelas_id" value="{{ $sesi->kelas_id }}">
                                        <input type="hidden" name="sesi_id" value="{{ $sesi->id }}">
                                        <input type="hidden" name="rematri_id" value="{{ $rematri->id }}">
                                        <input type="hidden" name="ttd_id" value="{{ $sesifoto->id }}">
                                        <div class="custom-file">
                                            <input type="file" accept="image/*" name="foto" class="custom-file-input"
                                                capture="camera" id="image" required>
                                            <label class="custom-file-label">Pilih File</label>
                                        </div>
                                    </div>
                                    <small><i>*Foto maksimal 2MB dan berekstensi jpeg, jpg, png.</i></small>
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
