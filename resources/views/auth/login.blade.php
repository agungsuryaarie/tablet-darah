@include('auth.layout.head')

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex">
                    <div class="img" style="background-image: url(dist/assets/img/blood-healt.jpg)"></div>
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <img src="dist/assets/img/Logo2.png" class="mb-3" style="width: 100px" />
                                <h6 class="mb-4">
                                    Silahkan Login Menggunakan E-mail dan Pasword Anda
                                </h6>
                            </div>
                        </div>
                        <form action="{{ route('login') }}"class="mb-3" method="post">
                            @csrf
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="email" class="form-label">Email</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input name="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Masukkan email anda" autofocus required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-envelope"></i></span>
                                </div>
                                @error('email')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input name="password" type="password"
                                        class="form-control  @error('password') is-invalid @enderror"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- <body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Admin</b>TTD</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Silahkan masuk akun anda!</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror""
                            placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                    <div class="input-group mb-3">
                        <input name="password" type="password"
                            class="form-control  @error('password') is-invalid @enderror" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                    </div>
                </form>
                <div class="copyright text-center mt-4">
                    © {{ date('Y') }}
                    <span> <a href="{{ '/login' }}">TTD (Tablet Tambah Darah)</a></span>
                </div>
            </div>
        </div>
    </div> --}}
@include('auth.layout.js')
