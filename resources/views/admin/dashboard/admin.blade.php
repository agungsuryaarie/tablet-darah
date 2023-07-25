@extends('admin.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Administrator</h1>
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
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $sekolah }}</h3>
                            <p>Sekolah</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-home"></i>
                        </div>
                        <a href="{{ route('sekolah.index') }}" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $posyandu }}</h3>
                            <p>Posyandu</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-home"></i>
                        </div>
                        <a href="{{ route('posyandu.index') }}" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

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

                {{-- Chart --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="bar-chart" style="height: 400px; width:100%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="col-md-12">
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
            var myTable = $(".data-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 20,
                lengthMenu: [10, 20],
                lengthChange: true,
                autoWidth: false,
                ajax: "{{ route('puskesmas.rematri.count') }}",
                columns: [{
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
                ],
            });
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
            grid: {
                borderWidth: 1,
                borderColor: '#f3f3f3',
                tickColor: '#f3f3f3'
            },
            series: {
                bars: {
                    show: true,
                    barWidth: 0.5,
                    align: 'center',
                },
            },
            colors: ['#3c8dbc'],
            // autoScale: "sliding-window",
            xaxis: {
                mode: "categories",
                tickLength: 0,
                font: {
                    size: 10,
                    variant: "small-caps"
                },
                // ticks: xaxis_ticks,
            },

        });
    </script>
@endsection
