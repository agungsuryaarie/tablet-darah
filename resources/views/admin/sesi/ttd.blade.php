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
                                href="{{ route('sesi.rematri', Crypt::encryptString($sesi->id)) }}">Detail Sesi</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-widget">
                    <div class="card-header">
                        <div class="user-block">
                            <h6><i class="fa fa-info-circle text-danger"></i> Harap posisikan rematri pada frame kamera.
                            </h6>
                        </div>
                        <!-- /.user-block -->
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                        <div class="col-md-4">
                            <div style="width: 400px; height: 300px;">
                                <video id="videoElement" class="img-thumbnail rounded" style="width: 100%; height: 100%;"
                                    autoplay></video>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer card-comments"
                        style="display: flex; justify-content: center; align-items: center;">
                        <div class="card-comment">
                            <button class="btn btn-primary" id="capture-btn"><i class="fa fa-camera"></i> Snapshot</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <form method="post" action="{{ route('sesi.uploadfoto') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="image-data" name="image">
                    <input type="hidden" name="kelas_id" value="{{ $sesi->kelas_id }}">
                    <input type="hidden" name="sesi_id" value="{{ $sesi->id }}">
                    <input type="hidden" name="rematri_id" value="{{ $rematri->id }}">
                    <input type="hidden" name="ttd_id" value="{{ $sesifoto->id }}">
                    <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                        <div class="col-md-4 mb-4">
                            <div style="width: 400px; height: 300px;">
                                <canvas class="img-thumbnail rounded" id="canvas"
                                    style="width: 100%; height: 100%;"></canvas>
                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="col-md-4" style="text-align: center">
                                <img src="{{ url('storage/foto-sesi/blank.png') }}" alt="Image Profile"
                    class="img-thumbnail rounded img-preview" width="120px">
                </div>
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <div class="input-group">
                            <input type="hidden" name="kelas_id" value="{{ $sesi->kelas_id }}">
                            <input type="hidden" name="sesi_id" value="{{ $sesi->id }}">
                            <input type="hidden" name="rematri_id" value="{{ $rematri->id }}">
                            <input type="hidden" name="ttd_id" value="{{ $sesifoto->id }}">
                            <div class="custom-file">
                                <input type="file" id="foto" name="foto" class="custom-file-input" id="foto" onchange="previewImg();" accept=".png, .jpg, .jpeg" required>
                                <label class="custom-file-label">Pilih File</label>
                            </div>
                        </div>
                        <small><i>*Foto maksimal 2MB dan berekstensi jpeg, jpg, png.</i></small>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary" style="margin-top:10px"><i class="fa fa-upload"></i> Upload</button>
                    </div>
                </div>
        </div> --}}
                    </div>
                    <div class="card-footer card-comments"
                        style="display: flex; justify-content: center; align-items: center;">
                        <button class="btn btn-success" type="submit"><i class="fa fa-upload"></i> Upload</button>
                    </div>
                </form>
            </div>
    </section>
@endsection
@section('script')
    <script>
        const video = document.getElementById('videoElement');
        const captureBtn = document.getElementById('capture-btn');
        const canvas = document.getElementById('canvas');
        const imageDataInput = document.getElementById('image-data');

        // Mengakses webcam saat halaman dimuat
        navigator.mediaDevices.enumerateDevices()
            .then(function(devices) {
                var videoDevices = devices.filter(function(device) {
                    return device.kind === 'videoinput';
                });

                if (videoDevices.length > 0) {
                    var constraints = {
                        video: {
                            deviceId: videoDevices[0].deviceId
                        }
                    };

                    return navigator.mediaDevices.getUserMedia(constraints);
                } else {
                    throw new Error('No video devices found.');
                }
            })
            .then(function(stream) {
                var videoElement = document.getElementById('videoElement');

                // Tampilkan video dari kamera di elemen video
                videoElement.srcObject = stream;
            })
            .catch(function(error) {
                console.error('Error accessing webcam:', error);
            });

        // Mengambil foto dari video saat tombol "Capture" diklik
        captureBtn.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Mengambil data gambar dalam format base64
            const imageData = canvas.toDataURL('image/jpeg');
            imageDataInput.value = imageData;
        });

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
