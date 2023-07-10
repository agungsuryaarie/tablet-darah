@extends('admin.layouts.app')

@section('content')
    @if (Auth::user()->role == 1 || Auth::user()->role == 2)
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard
                            @if (Auth::user()->role == 1)
                                Administrator
                            @elseif(Auth::user()->role == 2)
                                {{ Auth::user()->puskesmas->puskesmas }}
                            @endif
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @if (Auth::user()->role == 1)
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $puskesmas }}</h3>
                                    <p>Puskesmas</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-home"></i>
                                </div>
                                <a href="{{ route('puskesmas.index') }}" class="small-box-footer">Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-3 col-6">
                        <div class="small-box {{ Auth::user()->role == 1 ? 'bg-success' : 'bg-info' }}">
                            <div class="inner">
                                @if (Auth::user()->role == 1)
                                    <h3>{{ $sekolah }}</h3>
                                @else
                                    <h3>{{ $sekolah_puskes }}</h3>
                                @endif
                                <p>Sekolah</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-home"></i>
                            </div>
                            @if (Auth::user()->role == 1)
                                <a href="{{ route('sekolah.index') }}" class="small-box-footer">Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @else
                                <a href="{{ route('sekolah-binaan.index') }}" class="small-box-footer">Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box  {{ Auth::user()->role == 1 ? 'bg-warning' : 'bg-success' }} ">
                            <div class="inner">
                                @if (Auth::user()->role == 1)
                                    <h3>{{ $posyandu }}</h3>
                                @else
                                    <h3>{{ $posyandu_puskes }}</h3>
                                @endif
                                <p>Posyandu</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-home"></i>
                            </div>
                            @if (Auth::user()->role == 1)
                                <a href="{{ route('posyandu.index') }}" class="small-box-footer">Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @else
                                <a href="{{ route('posyandu-binaan.index') }}" class="small-box-footer">Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @endif
                        </div>
                    </div>
                    @if (Auth::user()->role == 1)
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $user_puskes }}</h3>
                                    <p>User Puskesmas</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person"></i>
                                </div>
                                <a href="{{ route('userpuskes.index') }}" class="small-box-footer">Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::user()->role == 2)
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
                    @endif

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="bar-chart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>

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
    @else
        <div class="panel-header bg-maroon mb-2">
            <div class="page-inner py-4">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-12 ml-4">
                                <h4 class="text-white pb-2 fw-bold">Dashboard
                                    @if (Auth::user()->role == 3)
                                        {{ Auth::user()->sekolah->sekolah }}
                                    @elseif(Auth::user()->role == 4)
                                        {{ Auth::user()->posyandu->posyandu }}
                                    @endif
                                    <h5 class="text-white op-7 mb-2">Aplikasi Tablet Tambah Darah</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
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
        </section>
    @endif
@endsection
@section('script')
    <script src="{{ url('plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ url('plugins/flot/plugins/jquery.flot.resize.js') }}"></script>
    <script src="{{ url('plugins/flot/plugins/jquery.flot.pie.js') }}"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            var myTable = DataTable("{{ route('puskesmas.rematri.count') }}", [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                },
                {
                    data: "puskesmas",
                    name: "puskesmas",
                },
                {
                    data: "rematri",
                    name: "rematri",
                },
            ]);
        });

        var puskesmas_count = {!! json_encode($puskesmas_count) !!};

        var bar_data = {
            data: puskesmas_count.map(function(item, index) {
                return [index + 1, item.rematri_count];
            }),
            bars: {
                show: true
            }
        };

        var xaxis_ticks = puskesmas_count.map(function(item, index) {
            return [index + 1, item.puskesmas];
        });

        $.plot('#bar-chart', [bar_data], {
            series: {
                bars: {
                    align: "center",
                    barWidth: 0.5,
                    lineWidth: 0,
                    fill: 0.7
                }
            },
            xaxis: {
                mode: "categories",
                tickLength: 0
            },
            yaxis: {
                tickSize: 1
            }
        });
    </script>
@endsection
