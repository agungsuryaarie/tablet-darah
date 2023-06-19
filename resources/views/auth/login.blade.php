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
                                <img src="{{ url('dist/assets/img/logo2.png') }}" class="mb-3" style="width: 100px" />
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
                <footer class="main-footer mt-2" style="display: flex; align-items: center; justify-content: center;">
                    <small>
                        <span style="margin-right: 10px;">Copyright &copy;{{ date('Y') }} <a
                                href="https://diskominfo.batubarakab.go.id" target="blank">Dinas Komunikasi dan
                                Informatika Kab. Batu Bara</a> All rights reserved.</span>
                    </small>
                </footer>
            </div>
        </div>
    </div>
</section>
@include('auth.layout.js')
