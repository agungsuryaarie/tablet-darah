@include('auth.layout.head')

<body class="hold-transition login-page">
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
    </div>
    @include('auth.layout.js')
