@extends('admin.layouts.app')

@section('content')
    <div class="panel-header bg-maroon mb-2">
        <div class="page-inner py-4">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12 ml-4">
                            <h4 class="text-white pb-2 fw-bold">Dashboard
                                {{ Auth::user()->sekolah->sekolah }}
                                <h5 class="text-white op-7 mb-2">Aplikasi Tablet Tambah Darah</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $rematri_count }}</h3>
                        <p>Jumlah Rematri</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="{{ route('rematri.index') }}" class="small-box-footer">Selengkapnya <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
