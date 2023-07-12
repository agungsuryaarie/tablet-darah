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
                        <figure class="highcharts-figure">
                            <div class='buttons'>
                                @php
                                    $lastMonth = $bulan->last();
                                @endphp
                                @foreach ($bulan as $month)
                                    <button value='{{ $month->bulan }}'
                                        class="btn btn-xs {{ $month == $lastMonth ? 'active' : '' }}">
                                        {{ $month->nama_bulan }}
                                    </button>
                                @endforeach
                            </div>
                            <div id="chart"></div>
                        </figure>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        $(document).ready(function() {
            // Fungsi untuk memuat grafik berdasarkan bulan yang dipilih
            function loadChartByMonth(month) {
                $.ajax({
                    url: '/rematri/puskesmas/' + month,
                    type: 'GET',
                    success: function(response) {
                        var seriesData = [];

                        // Mengelompokkan data berdasarkan nama sekolah
                        var groupedData = groupBy(response, 'nama_sekolah');

                        // Loop melalui setiap grup sekolah
                        for (var sekolah in groupedData) {
                            var dataPoints = groupedData[sekolah].map(function(item) {
                                return {
                                    name: item.sesi_week,
                                    y: item.rematri_count,
                                    ttd: item.ttd_count
                                };
                            });

                            seriesData.push({
                                name: sekolah,
                                data: dataPoints
                            });
                        }

                        var chartOptions = {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Grafik Perbandingan Jumlah Rematri dan Rematri Minum TTD Perbulan'
                            },
                            xAxis: {
                                type: 'category'
                            },
                            yAxis: {
                                title: {
                                    text: 'Jumlah'
                                }
                            },
                            tooltip: {
                                pointFormat: '<span style="color:{point.color}">\u25CF</span> <b>{series.name}</b><br/>' +
                                    'Sesi: {point.name}<br/>' +
                                    'Rematri Count: {point.y}<br/>' +
                                    'TTD Count: {point.ttd}'
                            },
                            series: seriesData
                        };

                        Highcharts.chart('chart', chartOptions);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Mengambil bulan terakhir dari tombol yang memiliki kelas "active"
            var lastActiveButton = $(".buttons button.active");
            var lastActiveMonth = lastActiveButton.val();

            // Memuat grafik berdasarkan bulan terakhir yang aktif
            loadChartByMonth(lastActiveMonth);

            // Fungsi untuk menangani klik tombol bulan
            $(".buttons button").click(function() {
                var month = $(this).val();
                // Memuat grafik berdasarkan bulan yang dipilih
                loadChartByMonth(month);

                // Hapus kelas "active" dari semua tombol
                $(".buttons button").removeClass("active");
                // Tambahkan kelas "active" ke tombol yang diklik
                $(this).addClass("active");
            });
        });

        // Fungsi untuk mengelompokkan data berdasarkan properti tertentu
        function groupBy(arr, prop) {
            return arr.reduce(function(groups, item) {
                var val = item[prop];
                groups[val] = groups[val] || [];
                groups[val].push(item);
                return groups;
            }, {});
        }
    </script>
@endsection
