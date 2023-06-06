@extends('admin.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ 'dashboard' }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-widget widget-user">
                            <div class="widget-user-header bg-info">
                                <h3 class="widget-user-username">{{ Auth::user()->profile->nama }}</h3>
                                @if (Auth::user()->role == 1)
                                    <h5 class="widget-user-desc">administrator</h5>
                                @else
                                    <h5 class="widget-user-desc">{{ Auth::user()->sekolah->nama_sekolah }}</h5>
                                @endif
                            </div>
                            <div class="widget-user-image">
                                @if (Auth::user()->profile->foto == null)
                                    <img src="{{ url('storage/foto-user/blank.png') }}" class="img-circle elevation-2"
                                        alt="User Image">
                                @else
                                    <img src="{{ url('storage/foto-user/' . Auth::user()->profile->foto) }}"
                                        class="img-circle elevation-2" alt="User Image">
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="col-sm-12 text-center">
                                    <div class="description-block mt-5 mb-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h6>
                                        <i class="fas fa-user"></i> Profil Saya
                                        <div class="float-right">
                                            <a href="#" class="btn btn-warning btn-xs text-white" title="Ubah Profil"
                                                data-toggle="modal" data-target="#modal-lg-p{{ $user->id }}">
                                                <i class="fa fa-edit">
                                                </i>
                                            </a>
                                            <a href="#" class="btn btn-warning btn-xs text-white"
                                                title="Ubah Password" data-toggle="modal"
                                                data-target="#modal-lg-ps{{ $user->id }}">
                                                <i class="fa fa-key">
                                                </i>
                                            </a>
                                            <a href="#" class="btn btn-warning btn-xs text-white" title="Ubah Foto"
                                                data-toggle="modal" data-target="#modal-lg-f{{ $user->id }}">
                                                <i class="fa fa-camera">
                                                </i>
                                            </a>
                                        </div>
                                    </h6>
                                </div>
                            </div>
                            <div class="col-sm-4 invoice-col mt-4">
                                <h6><b>NIK</b></h6>
                                <span>{{ $user->nik }}</span>
                                <h6 class="mt-2"><b>Nama</b></h6>
                                <span>{{ $user->nama }}</span>
                                <h6 class="mt-2"><b>Email</b></h6>
                                <span>{{ $user->email }}</span>
                                <h6 class="mt-2"><b>Nomor Handphone</b></h6>
                                <span>{{ $user->nohp }}</span>
                                <h6 class="mt-2"><b>Jenis Kelamin</b></h6>
                                @if ($user->profile->gender == null)
                                    <span class="text-danger"><i>* tidak ada</i></span>
                                @else
                                    @if ($user->profile->gender == 'L')
                                        Laki-laki
                                    @else
                                        Perempuan
                                    @endif
                                @endif
                                <h6 class="mt-2"><b>Tempat Lahir</b></h6>
                                @if ($user->profile->tempat_lahir == null)
                                    <span class="text-danger"><i>* tidak ada</i></span>
                                @else
                                    {{ $user->profile->tempat_lahir }}
                                @endif
                                <h6 class="mt-2"><b>Tanggal Lahir</b></h6>
                                @if ($user->profile->tgl_lahir == null)
                                    <span class="text-danger"><i>* tidak ada</i></span>
                                @else
                                    {{ \Carbon\Carbon::parse($user->profile->tgl_lahir)->translatedFormat('l, d F Y') }}
                                @endif
                                <h6 class="mt-2"><b>Alamat</b></h6>
                                @if ($user->profile->alamat == null)
                                    <span class="text-danger"><i>* tidak ada</i></span>
                                @else
                                    {{ $user->profile->alamat }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal Update Profil --}}
    <div class="modal fade" id="modal-lg-p{{ $user->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Profil</h4>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <form method="POST" action="{{ route('profil.update', $user->id) }}">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ old('nik', $user->nik) }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama" placeholder="Nama"
                                            autocomplete="off" value="{{ old('nama', $user->nama) }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email" placeholder="Email"
                                            autocomplete="off" value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nomor Handphone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nohp"
                                            placeholder="Nomor Handphone" autocomplete="off"
                                            value="{{ old('nohp', $user->nohp) }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <div class="radio-btn">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="L"
                                                    name="jenis_kelamin" id="jk1"
                                                    {{ old('jenis_kelamin', $user->profile->gender) == 'L' ? 'checked' : '' }}>
                                                <label for="jk1" class="custom-control-label">Laki-laki</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="P"
                                                    name="jenis_kelamin" id="jk2"
                                                    {{ old('jenis_kelamin', $user->profile->gender) == 'P' ? 'checked' : '' }}>
                                                <label for="jk2" class="custom-control-label">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <textarea name="tempat_lahir" class="form-control rows="3">{{ old('tempat_lahir', $user->profile->tempat_lahir) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" class="form-control"
                                            value="{{ old('tgl_lahir', $user->profile->tgl_lahir) }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control rows="3">{{ old('alamat', $user->profile->alamat) }}</textarea>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default btn-sm"
                                        data-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Update Password --}}
    <div class="modal fade" id="modal-lg-ps{{ $user->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Password</h4>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <form method="POST" action="{{ route('profil.update.password', $user->id) }}">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>New Password <span class="text-danger">*</span></label>
                                        <input type="password" name="npassword" class="form-control"
                                            value="{{ old('npassword') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Re-Password <span class="text-danger">*</span></label>
                                        <input type="password" name="nrepassword" class="form-control"
                                            value="{{ old('rpassword') }}" required>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default btn-sm"
                                        data-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Update Foto --}}
    <div class="modal fade" id="modal-lg-f{{ $user->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Foto</h4>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <form method="POST" action="{{ route('profil.update.foto', $user->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        @if (Auth::user()->profile->foto == null)
                                            <img src="{{ url('storage/foto-user/blank.png') }}" alt="Image Profile"
                                                class="img-thumbnail rounded img-preview" width="120px">
                                        @else
                                            <img src="{{ url('storage/foto-user/' . $user->profile->foto) }}"
                                                alt="Image Profile" class="img-thumbnail rounded img-preview"
                                                width="120px">
                                        @endif
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="foto" class="custom-file-input"
                                                    id="foto" onchange="previewImg();" accept=".png, .jpg, .jpeg"
                                                    required>
                                                <label class="custom-file-label">Pilih File</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-default btn-sm"
                                        data-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
