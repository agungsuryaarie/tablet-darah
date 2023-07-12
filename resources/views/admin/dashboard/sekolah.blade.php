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
    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-center align-items-center">
                <div class="col-md-6">
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
                    url: '/rematri/sekolah/' + month,
                    type: 'GET',
                    success: function(response) {
                        var label = response.map(function(item) {
                            return item.sesi_week;
                        });

                        var rematri = response.map(function(item) {
                            return item.rematri_count;
                        });

                        var ttd = response.map(function(item) {
                            return parseInt(item.ttd_count);
                        });

                        var chartOptions = {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Grafik Perbandingan Jumlah Rematri dan Rematri Minum TTD Perbulan'
                            },
                            xAxis: {
                                categories: label
                            },
                            yAxis: {
                                title: {
                                    text: 'Jumlah'
                                }
                            },
                            series: [{
                                name: 'Jumlah Rematri',
                                data: rematri
                            }, {
                                name: 'Jumlah Minum TTD',
                                data: ttd
                            }]
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
    </script>
@endsection
