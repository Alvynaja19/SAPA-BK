@extends('layouts.tailadmin')

@section('title', 'Dashboard Guru BK | SAPA BK SMAN 4 Jember')

@push('styles')
<!-- Google Font: Poppins & FontAwesome & Feather Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('fonts/feather.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
  .gradient-able-scope {
    font-family: 'Poppins', sans-serif !important;
    color: #222;
  }
  .gradient-able-scope .card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: none !important;
    border-radius: 4px;
    box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
    margin-bottom: 25px;
    transition: all 0.3s ease-in-out;
  }
  .gradient-able-scope .card .card-header {
    background-color: transparent;
    border-bottom: 1px solid #f1f1f1;
    padding: 20px 25px;
    position: relative;
  }
  .gradient-able-scope .card .card-header h5 {
    margin-bottom: 0;
    color: #000;
    font-size: 17px;
    font-weight: 500;
    line-height: 1.1;
  }
  .gradient-able-scope .card .card-body {
    padding: 25px;
  }
  
  /* Gradients */
  .bg-c-blue {
    background: linear-gradient(45deg, #4099ff, #73b4ff) !important;
  }
  .bg-c-green {
    background: linear-gradient(45deg, #2ed8b6, #59e0c5) !important;
  }
  .bg-c-yellow {
    background: linear-gradient(45deg, #ffb64d, #ffcb80) !important;
  }
  .bg-c-red {
    background: linear-gradient(45deg, #ff5370, #ff869a) !important;
  }
  .bg-primary-custom {
    background: #4099ff !important;
  }

  /* Order Cards */
  .order-card {
    color: #fff !important;
    border: none !important;
    border-radius: 4px !important;
    box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
  }
  .order-card h6 {
    color: #fff !important;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 0;
  }
  .order-card h2 {
    font-size: 32px;
    font-weight: 300;
    margin-top: 10px;
    margin-bottom: 10px;
    text-align: right;
    color: #fff !important;
    line-height: 1.2;
  }
  .order-card h2 i {
    float: left;
    font-size: 28px;
    line-height: 38px;
  }
  .order-card p {
    margin-bottom: 0;
    font-size: 13px;
    color: #fff !important;
  }
  .order-card p span.float-end {
    float: right;
  }

  /* Text Colors */
  .text-c-blue { color: #4099ff !important; }
  .text-c-green { color: #2ed8b6 !important; }
  .text-c-yellow { color: #ffb64d !important; }
  .text-c-red { color: #ff5370 !important; }

  /* Social Cards */
  .social-card .card-body {
    text-align: center;
    padding: 30px 20px;
  }
  .f-40 { font-size: 40px; }
  .f-10 { font-size: 10px; }
  .m-t-20 { margin-top: 20px; }
  .m-b-20 { margin-bottom: 20px; }
  .btn-primary-custom {
    background-color: #4099ff;
    border-color: #4099ff;
    color: #fff !important;
    border-radius: 4px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 500;
    display: inline-block;
    text-decoration: none;
    transition: all 0.2s;
  }
  .btn-primary-custom:hover {
    background-color: #2e88ee;
  }
  .btn-success-custom {
    background-color: #2ed8b6;
    border-color: #2ed8b6;
    color: #fff !important;
    border-radius: 4px;
    padding: 7px 18px;
    font-size: 13px;
    font-weight: 500;
    display: inline-block;
    text-decoration: none;
    transition: all 0.2s;
  }
  .btn-success-custom:hover {
    background-color: #22bf9e;
  }

  /* Feed Blog */
  .feed-blog {
    border-left: 1px solid #d6d6d6;
    margin-left: 20px;
    padding-left: 0;
    list-style: none;
  }
  .feed-blog li {
    position: relative;
    padding-left: 30px;
    margin-bottom: 35px;
    list-style: none;
  }
  .feed-blog li:last-child {
    margin-bottom: 0;
  }
  .feed-blog li h6 {
    line-height: 1.5;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 6px;
    color: #222;
  }
  .feed-blog li .feed-user-img {
    position: absolute;
    left: -20px;
    top: -5px;
  }
  .feed-blog li .feed-user-img .img-initial {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    background-color: #eafbf8;
    color: #059669;
    border: 2px solid #2ed8b6;
  }
  .feed-blog li .feed-user-img:after {
    content: '';
    position: absolute;
    top: 3px;
    right: 3px;
    border: 3px solid transparent;
    border-radius: 50%;
    width: 10px;
    height: 10px;
  }
  .feed-blog li.active-feed .feed-user-img:after {
    border-color: #2ed8b6;
  }
  .feed-blog li.diactive-feed .feed-user-img:after {
    border-color: #4099ff;
  }
  .badge-custom {
    padding: 3px 8px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 3px;
    display: inline-block;
  }
  .bg-danger-custom { background-color: #ff5370 !important; color: #fff !important; }
  .bg-success-custom { background-color: #2ed8b6 !important; color: #fff !important; }
  .bg-primary-custom { background-color: #4099ff !important; color: #fff !important; }
</style>
@endpush

@section('content')
<div class="gradient-able-scope space-y-6">

  <!-- 1. Empat Order Cards (Data SAPA BK dengan Desain Asli Gradient Able) -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    
    <!-- Card 1: Konsultasi Chatbot AI (Blue Gradient) -->
    <div class="card bg-c-blue order-card">
      <div class="card-body">
        <h6>Konsultasi Chatbot AI</h6>
        <h2>
          <i class="feather icon-message-circle"></i>
          <span>{{ number_format($stats['total_ai_sessions'] ?? 0) }}</span>
        </h2>
        <p>
          Sesi Terselesaikan
          <span class="float-end">{{ number_format($stats['total_ai_sessions'] ?? 0) }} Sesi</span>
        </p>
      </div>
    </div>

    <!-- Card 2: Live Chat Guru BK (Green Gradient) -->
    <div class="card bg-c-green order-card">
      <div class="card-body">
        <h6>Live Chat Guru BK</h6>
        <h2>
          <i class="feather icon-users"></i>
          <span>{{ number_format($stats['my_live_sessions'] ?? $stats['total_live_sessions'] ?? 0) }}</span>
        </h2>
        <p>
          Antrean Aktif
          <span class="float-end">{{ number_format($stats['active_queue'] ?? 0) }} Siswa</span>
        </p>
      </div>
    </div>

    <!-- Card 3: Total Siswa Terdaftar (Yellow Gradient) -->
    <div class="card bg-c-yellow order-card">
      <div class="card-body">
        <h6>Total Siswa Terdaftar</h6>
        <h2>
          <i class="feather icon-user-check"></i>
          <span>{{ number_format($stats['total_siswa'] ?? 0) }}</span>
        </h2>
        <p>
          Siswa Aktif Bimbingan
          <span class="float-end">SMAN 4 Jember</span>
        </p>
      </div>
    </div>

    <!-- Card 4: Konseling Tuntas (Red Gradient) -->
    <div class="card bg-c-red order-card">
      <div class="card-body">
        <h6>Konseling Tuntas</h6>
        <h2>
          <i class="feather icon-award"></i>
          <span>{{ number_format($handlingStatus['completed']['count'] ?? 0) }}</span>
        </h2>
        <p>
          Tingkat Efektivitas
          <span class="float-end">{{ $handlingStatus['completed']['percentage'] ?? 0 }}% Kasus</span>
        </p>
      </div>
    </div>

  </div>

  <!-- 2. Baris Grafik: Tren Konsultasi Siswa & Donut Analytics Layanan -->
  <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    
    <!-- Unique Visitor Style: Tren Konsultasi Chatbot AI vs Live Chat Guru BK -->
    <div class="card">
      <div class="card-header">
        <h5>Tren Konsultasi Siswa</h5>
      </div>
      <div class="card-body" style="padding: 20px 20px 5px 20px;">
        <div id="unique-visitor-chart" style="min-height: 280px;"></div>
      </div>
    </div>

    <!-- Customers Donut Charts (2 Kartu Berdampingan Sesuai Gradient Able) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      
      <!-- Customers 1: Rasio Layanan (White Card) -->
      <div class="card">
        <div class="card-body">
          <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <span style="font-size: 15px; color: #666; font-weight: 500;">Rasio Layanan</span>
            <div style="text-align: right;">
              <h2 style="font-size: 28px; font-weight: 600; margin: 0; line-height: 1.1; color: #222;">
                {{ number_format($stats['total_percakapan'] ?? 0) }}
              </h2>
              <span class="text-c-green" style="font-size: 13px; font-weight: 600;">
                {{ $trendData['periods']['year']['pct_total'] ?? '+100%' }} <i class="feather icon-trending-up"></i>
              </span>
            </div>
          </div>
          <div id="customer-chart" style="margin: 5px 0;"></div>
          <div style="display: flex; justify-content: space-around; text-align: center; margin-top: 15px;">
            <div>
              <h3 style="margin: 0; font-size: 20px; font-weight: 600; color: #222;">
                <i class="fas fa-circle f-10 text-c-green" style="margin-right: 6px;"></i>{{ number_format($stats['total_ai_sessions'] ?? 0) }}
              </h3>
              <span style="font-size: 12px; color: #888;">Chatbot AI</span>
            </div>
            <div>
              <h3 style="margin: 0; font-size: 20px; font-weight: 600; color: #222;">
                <i class="fas fa-circle text-c-blue f-10" style="margin-right: 6px;"></i>{{ number_format($stats['total_live_sessions'] ?? 0) }}
              </h3>
              <span style="font-size: 12px; color: #888;">Live Guru BK</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Customers 2: Alur Penanganan (Blue Card) -->
      <div class="card bg-primary-custom" style="color: #fff;">
        <div class="card-body">
          <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <span style="font-size: 15px; color: #fff; font-weight: 500;">Penanganan Kasus</span>
            <div style="text-align: right;">
              <h2 style="font-size: 28px; font-weight: 600; margin: 0; line-height: 1.1; color: #fff;">
                {{ number_format($handlingStatus['total_cases'] ?? 0) }}
              </h2>
              <span style="font-size: 13px; font-weight: 600; color: #fff;">
                {{ $handlingStatus['completed']['percentage'] ?? 0 }}% Tuntas <i class="feather icon-check"></i>
              </span>
            </div>
          </div>
          <div id="customer-chart-1" style="margin: 5px 0;"></div>
          <div style="display: flex; justify-content: space-around; text-align: center; margin-top: 15px;">
            <div>
              <h3 style="margin: 0; font-size: 20px; font-weight: 600; color: #fff;">
                <i class="fas fa-circle f-10 text-c-green" style="margin-right: 6px;"></i>{{ number_format($handlingStatus['completed']['count'] ?? 0) }}
              </h3>
              <span style="font-size: 12px; color: #fff;">Tuntas</span>
            </div>
            <div>
              <h3 style="margin: 0; font-size: 20px; font-weight: 600; color: #fff;">
                <i class="fas fa-circle f-10" style="color: #fff; margin-right: 6px;"></i>{{ number_format(($handlingStatus['in_progress']['count'] ?? 0) + ($handlingStatus['waiting']['count'] ?? 0)) }}
              </h3>
              <span style="font-size: 12px; color: #fff;">Dalam Proses</span>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- 3. Baris Social Cards & Activity Feed (Data Riil SAPA BK) -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Kolom Kiri: 2 Social Cards (4 Kolom) -->
    <div class="lg:col-span-4 flex flex-col gap-6">
      
      <!-- Social Card 1: Antrean Siaga Konseling -->
      <div class="card social-card">
        <div class="card-body">
          <i class="d-block f-40 text-c-blue feather icon-message-circle" style="display: block; margin-bottom: 15px;"></i>
          <h4 class="m-t-20" style="font-size: 20px; font-weight: 600; margin-bottom: 8px;">
            <span class="text-c-blue">{{ number_format($stats['active_queue'] ?? 0) }}</span> Antrean Siaga
          </h4>
          <p class="m-b-20" style="color: #888; font-size: 13px; margin-bottom: 20px;">
            Siswa membutuhkan respon bimbingan langsung
          </p>
          <a href="{{ route('bk.live-chat') }}" class="btn-primary-custom">
            Buka Live Chat
          </a>
        </div>
      </div>

      <!-- Social Card 2: Materi & Panduan BK -->
      <div class="card social-card">
        <div class="card-body">
          <i class="d-block f-40 text-c-green feather icon-book-open" style="display: block; margin-bottom: 15px;"></i>
          <h4 class="m-t-20" style="font-size: 20px; font-weight: 600; margin-bottom: 8px;">
            <span class="text-c-green">+{{ number_format(($stats['total_ebook'] ?? 0) + ($stats['total_artikel'] ?? 0)) }}</span> Materi BK
          </h4>
          <p class="m-b-20" style="color: #888; font-size: 13px; margin-bottom: 20px;">
            E-Book panduan bimbingan &amp; artikel motivasi
          </p>
          <a href="{{ route('bk.ebook') }}" class="btn-success-custom">
            Kelola Materi
          </a>
        </div>
      </div>

    </div>

    <!-- Kolom Kanan: Activity Feed (8 Kolom) Riwayat Bimbingan Siswa -->
    <div class="lg:col-span-8">
      <div class="card">
        <div class="card-header">
          <h5>Activity Feed Bimbingan Siswa</h5>
        </div>
        <div class="card-body" style="padding-top: 25px;">
          <ul class="feed-blog ps-0">
            
            @forelse($studentActivities as $index => $activity)
              <li class="{{ $index === 0 ? 'active-feed' : 'diactive-feed' }}">
                <div class="feed-user-img">
                  <div class="img-initial">
                    {{ $activity['avatar_letter'] ?? 'S' }}
                  </div>
                </div>
                <h6>
                  <span class="badge-custom {{ $index % 2 === 0 ? 'bg-primary-custom' : 'bg-success-custom' }}">
                    {{ $activity['badge'] ?? 'Konseling' }}
                  </span>
                  <span style="font-weight: 600; margin-left: 4px;">{{ $activity['student_name'] }}</span>
                  <small style="color: #888; font-weight: 400; font-size: 12px; margin-left: 5px;">
                    {{ $activity['time_ago'] }}
                  </small>
                </h6>
                <p style="color: #666; font-size: 13px; line-height: 1.6; margin: 8px 0 10px 0;">
                  {{ $activity['title'] }}
                  @if(!empty($activity['detail']))
                    : <span style="color: #888;">{{ $activity['detail'] }}</span>
                  @endif
                </p>
                <div>
                  <a href="{{ $activity['action_url'] }}" class="text-c-blue" style="font-size: 12px; font-weight: 600; text-decoration: none;">
                    Periksa Sesi Konseling &rarr;
                  </a>
                </div>
              </li>
            @empty
              <li class="active-feed">
                <div class="feed-user-img">
                  <div class="img-initial">BK</div>
                </div>
                <h6>
                  <span class="badge-custom bg-primary-custom">Informasi</span>
                  Layanan Bimbingan Konseling Siaga
                </h6>
                <p style="color: #666; font-size: 13px; line-height: 1.6; margin: 8px 0 10px 0;">
                  Belum ada percakapan atau konsultasi baru dari siswa hari ini. Sistem siaga menerima konsultasi melalui Chatbot AI maupun Live Chat Guru BK.
                </p>
              </li>
            @endforelse

          </ul>
        </div>
      </div>
    </div>

  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // 1. Data Riil Tren Konsultasi Siswa (Chatbot AI vs Live Chat Guru BK)
    var trendLabels = {!! json_encode($trendData['periods']['year']['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!};
    var trendAiData = {!! json_encode($trendData['periods']['year']['ai'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};
    var trendLiveData = {!! json_encode($trendData['periods']['year']['live'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!};

    var uniqueVisitorOptions = {
      chart: {
        height: 280,
        type: 'line',
        toolbar: {
          show: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      legend: {
        position: 'top',
        horizontalAlign: 'right',
        markers: {
          radius: 12
        },
        itemMargin: {
          horizontal: 8
        }
      },
      xaxis: {
        categories: trendLabels,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: '#a3aed0'
          }
        }
      },
      yaxis: {
        show: true,
        min: 0,
        labels: {
          style: {
            colors: '#a3aed0'
          }
        }
      },
      colors: ['#4099ff', '#2ed8b6'],
      markers: {
        size: 5,
        colors: ['#4099ff', '#2ed8b6'],
        opacity: 0.9,
        strokeWidth: 2,
        hover: {
          size: 7
        }
      },
      grid: {
        borderColor: '#f1f1f1'
      },
      series: [
        {
          name: 'Chatbot AI',
          data: trendAiData
        },
        {
          name: 'Live Chat Guru BK',
          data: trendLiveData
        }
      ]
    };
    var chart1 = new ApexCharts(document.querySelector("#unique-visitor-chart"), uniqueVisitorOptions);
    chart1.render();

    // 2. Customer Donut Chart: Rasio Layanan (Chatbot AI vs Live Guru BK)
    var aiCount = {{ $stats['total_ai_sessions'] ?? 0 }};
    var liveCount = {{ $stats['total_live_sessions'] ?? 0 }};
    var donutData1 = (aiCount === 0 && liveCount === 0) ? [0, 0] : [aiCount, liveCount];

    var customerChartOptions = {
      chart: {
        height: 150,
        type: 'donut'
      },
      dataLabels: {
        enabled: false
      },
      plotOptions: {
        pie: {
          donut: {
            size: '75%'
          }
        }
      },
      labels: ['Chatbot AI', 'Live Guru BK'],
      legend: {
        show: false
      },
      tooltip: {
        theme: 'dark'
      },
      grid: {
        padding: {
          top: 10,
          right: 0,
          bottom: 0,
          left: 0
        }
      },
      colors: ['#2ed8b6', '#4099ff'],
      stroke: {
        width: 0
      },
      series: donutData1
    };
    var chart2 = new ApexCharts(document.querySelector("#customer-chart"), customerChartOptions);
    chart2.render();

    // 3. Customer Donut Chart: Penanganan Kasus (Tuntas vs Dalam Proses)
    var completedCases = {{ $handlingStatus['completed']['count'] ?? 0 }};
    var inProgressCases = {{ ($handlingStatus['in_progress']['count'] ?? 0) + ($handlingStatus['waiting']['count'] ?? 0) }};
    var donutData2 = (completedCases === 0 && inProgressCases === 0) ? [0, 0] : [completedCases, inProgressCases];

    var customerChart1Options = {
      chart: {
        height: 150,
        type: 'donut'
      },
      dataLabels: {
        enabled: false
      },
      plotOptions: {
        pie: {
          donut: {
            size: '75%'
          }
        }
      },
      labels: ['Kasus Tuntas', 'Dalam Proses'],
      legend: {
        show: false
      },
      tooltip: {
        theme: 'light'
      },
      grid: {
        padding: {
          top: 10,
          right: 0,
          bottom: 0,
          left: 0
        }
      },
      colors: ['#2ed8b6', '#ffffff99'],
      stroke: {
        width: 0
      },
      series: donutData2
    };
    var chart3 = new ApexCharts(document.querySelector("#customer-chart-1"), customerChart1Options);
    chart3.render();
  });
</script>
@endpush
