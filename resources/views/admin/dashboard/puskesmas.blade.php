@extends('admin.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard
                        {{ Auth::user()->puskesmas->puskesmas }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ $menu }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $sekolah_puskes }}</h3>
                            <p>Sekolah</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-home"></i>
                        </div>
                        <a href="{{ route('sekolah-binaan.index') }}" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $posyandu_puskes }}</h3>
                            <p>Posyandu</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-home"></i>
                        </div>
                        <a href="{{ route('posyandu-binaan.index') }}" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $usersekolah_puskes }}</h3>
                            <p>User Sekolah</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="{{ route('usersekolah.index') }}" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $userposyandu_puskes }}</h3>
                            <p>User Posyandu</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="{{ route('userposyandu.index') }}" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{-- Chart --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="bar-chart" style="height: 400px; width:100%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="col-md-6">
                    <x-datatableNoHeader header="Jumlah Rematri Perpuskesmas">
                        <th style="width: 3%" class="text-center"></th>
                        <th>Puskesmas</th>
                        <th style="width:12%" class="text-center">Jumlah Rematri</th>
                    </x-datatableNoHeader>
                </div>
            </div>
        </div>
    </section>
@endsection
