@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-4 col-md-12 col-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div
                        class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="../assets/img/icons/unicons/chart-success.png"
                                alt="chart success" class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">User</span>
                    <h3 class="card-title mb-2">{{ \App\Models\User::count() }}</h3>
                    <small class="text-disabled fw-semibold">total user</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div
                        class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="../assets/img/icons/unicons/wallet-info.png"
                                alt="Credit Card" class="rounded" />
                        </div>
                    </div>
                    <span>Masyarakat</span>
                    <h3 class="card-title text-nowrap mb-1">{{ \App\Models\Masyarakat::count() }}</h3>
                    <small class="text-disabled fw-semibold">total masyarakat</small>
                </div>
            </div>
        </div>
        <!-- Tracking -->
        @php
            $diproses = \App\Models\PenerimaanDana::where('status', 1)->count();
            $terkirim = \App\Models\PenerimaanDana::where('status', 2)->count();
        @endphp
        <div class="col-md-6 col-lg-6 col-xl-4 order-0 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Statistik Penerimaan Dana</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">{{ \App\Models\PenerimaanDana::count() }}</h2>
                            <span>Total Penerimaan</span>
                        </div>
                        <div id="penerimaanDanaChart"></div>
                    </div>
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="bx bx-time-five"></i></span>
                            </div>
                            <div
                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Diproses</h6>
                                    {{--  <small class="text-muted">Mobile, Earbuds, TV</small>  --}}
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">{{ $diproses }}</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i
                                        class="bx bx-check"></i></span>
                            </div>
                            <div
                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Terkirim</h6>
                                    {{--  <small class="text-muted">T-shirt, Jeans, Shoes</small>  --}}
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">{{ $terkirim }}</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Tracking -->
    </div>
</div>
@endsection
@push('extraJS')
<script>
    let cardColor, headingColor, axisColor, shadeColor, borderColor;

    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;

    var diproses = "{{ $diproses }}";
    var terkirim = "{{ $terkirim }}";
    var total = parseInt(diproses) + parseInt(terkirim);
    console.log('total '+total)
    
    const chartOrderStatistics = document.querySelector('#penerimaanDanaChart'),
    orderChartConfig = {
      chart: {
        height: 165,
        width: 130,
        type: 'donut'
      },
      labels: ['Diproses', 'Terkirim'],
      series: [diproses, terkirim],
      colors: [config.colors.primary, config.colors.success],
      stroke: {
        width: 5,
        colors: cardColor
      },
      dataLabels: {
        enabled: false,
      },
      legend: {
        show: false
      },
      grid: {
        padding: {
          top: 0,
          bottom: 0,
          right: 15
        }
      },
      plotOptions: {
        pie: {
        expandOnClick: false,
          donut: {
            size: '75%',
            labels: {
              show: false,
              value: {
                fontSize: '1.5rem',
                fontFamily: 'Public Sans',
                color: headingColor,
                offsetY: -15,
                formatter: function (val) {
                  //return (parseInt(val) / parseInt(total) * 100) + '%';
                  return (parseInt(val) / parseInt(total) * 100) + '%';
                }
              },
              name: {
                offsetY: 20,
                fontFamily: 'Public Sans'
              },
            }
          }
        }
      }
    };
  if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
    const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
    statisticsChart.render();
  }
</script>
@endpush