@extends('layouts.tailadmin')

@section('title', 'Dashboard | Gradient Able Template')

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
    margin-bottom: 40px;
    list-style: none;
  }
  .feed-blog li:last-child {
    margin-bottom: 0;
  }
  .feed-blog li h6 {
    line-height: 1.5;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 10px;
    color: #222;
  }
  .feed-blog li .feed-user-img {
    position: absolute;
    left: -20px;
    top: -5px;
  }
  .feed-blog li .feed-user-img img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
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
    border-color: #ff5370;
  }
  .img-radius {
    border-radius: 50%;
  }
  .wid-100 {
    width: 100px;
    height: 70px;
    object-fit: cover;
    border-radius: 4px;
  }
  .badge-custom {
    padding: 4px 8px;
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

  <!-- 1. Empat Order Cards (Gradient Able) -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    
    <!-- Card 1: Orders Received -->
    <div class="card bg-c-blue order-card">
      <div class="card-body">
        <h6>Orders Received</h6>
        <h2>
          <i class="feather icon-shopping-cart"></i>
          <span>{{ $stats['total_ai_sessions'] > 0 ? $stats['total_ai_sessions'] : '486' }}</span>
        </h2>
        <p>
          Completed Orders
          <span class="float-end">{{ $stats['total_ai_sessions'] > 0 ? $stats['total_ai_sessions'] : '351' }}</span>
        </p>
      </div>
    </div>

    <!-- Card 2: Total Sales -->
    <div class="card bg-c-green order-card">
      <div class="card-body">
        <h6>Total Sales</h6>
        <h2>
          <i class="feather icon-tag"></i>
          <span>{{ $stats['total_live_sessions'] > 0 ? $stats['total_live_sessions'] : '1641' }}</span>
        </h2>
        <p>
          This Month
          <span class="float-end">{{ $stats['total_live_sessions'] > 0 ? $stats['total_live_sessions'] : '213' }}</span>
        </p>
      </div>
    </div>

    <!-- Card 3: Revenue -->
    <div class="card bg-c-yellow order-card">
      <div class="card-body">
        <h6>Revenue</h6>
        <h2>
          <i class="feather icon-repeat"></i>
          <span>${{ $stats['total_siswa'] > 0 ? number_format($stats['total_siswa'] * 50 + 2562) : '42,562' }}</span>
        </h2>
        <p>
          This Month
          <span class="float-end">${{ $stats['total_siswa'] > 0 ? number_format($stats['total_siswa'] * 6 + 32) : '5,032' }}</span>
        </p>
      </div>
    </div>

    <!-- Card 4: Total Profit -->
    <div class="card bg-c-red order-card">
      <div class="card-body">
        <h6>Total Profit</h6>
        <h2>
          <i class="feather icon-award"></i>
          <span>${{ ($handlingStatus['completed']['count'] ?? 0) > 0 ? number_format(($handlingStatus['completed']['count'] ?? 0) * 50 + 562) : '9,562' }}</span>
        </h2>
        <p>
          This Month
          <span class="float-end">${{ ($handlingStatus['completed']['count'] ?? 0) > 0 ? number_format(($handlingStatus['completed']['count'] ?? 0) * 3 + 42) : '542' }}</span>
        </p>
      </div>
    </div>

  </div>

  <!-- 2. Baris Grafik: Unique Visitor & Customers Donut Charts -->
  <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    
    <!-- Unique Visitor (Line Chart) -->
    <div class="card">
      <div class="card-header">
        <h5>Unique Visitor</h5>
      </div>
      <div class="card-body" style="padding: 20px 20px 5px 20px;">
        <div id="unique-visitor-chart" style="min-height: 280px;"></div>
      </div>
    </div>

    <!-- Customers Donut Charts (2 Kartu Berdampingan) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      
      <!-- Customers (White Card) -->
      <div class="card">
        <div class="card-body">
          <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <span style="font-size: 15px; color: #666; font-weight: 500;">Customers</span>
            <div style="text-align: right;">
              <h2 style="font-size: 28px; font-weight: 600; margin: 0; line-height: 1.1; color: #222;">826</h2>
              <span class="text-c-green" style="font-size: 13px; font-weight: 600;">
                8.2% <i class="feather icon-trending-up"></i>
              </span>
            </div>
          </div>
          <div id="customer-chart" style="margin: 5px 0;"></div>
          <div style="display: flex; justify-content: space-around; text-align: center; margin-top: 15px;">
            <div>
              <h3 style="margin: 0; font-size: 22px; font-weight: 600; color: #222;">
                <i class="fas fa-circle f-10 text-c-green" style="margin-right: 6px;"></i>674
              </h3>
              <span style="font-size: 13px; color: #888;">New</span>
            </div>
            <div>
              <h3 style="margin: 0; font-size: 22px; font-weight: 600; color: #222;">
                <i class="fas fa-circle text-c-blue f-10" style="margin-right: 6px;"></i>182
              </h3>
              <span style="font-size: 13px; color: #888;">Return</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Customers (Blue Card) -->
      <div class="card bg-primary-custom" style="color: #fff;">
        <div class="card-body">
          <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <span style="font-size: 15px; color: #fff; font-weight: 500;">Customers</span>
            <div style="text-align: right;">
              <h2 style="font-size: 28px; font-weight: 600; margin: 0; line-height: 1.1; color: #fff;">826</h2>
              <span style="font-size: 13px; font-weight: 600; color: #fff;">
                8.2% <i class="feather icon-trending-up"></i>
              </span>
            </div>
          </div>
          <div id="customer-chart-1" style="margin: 5px 0;"></div>
          <div style="display: flex; justify-content: space-around; text-align: center; margin-top: 15px;">
            <div>
              <h3 style="margin: 0; font-size: 22px; font-weight: 600; color: #fff;">
                <i class="fas fa-circle f-10 text-c-green" style="margin-right: 6px;"></i>674
              </h3>
              <span style="font-size: 13px; color: #fff;">New</span>
            </div>
            <div>
              <h3 style="margin: 0; font-size: 22px; font-weight: 600; color: #fff;">
                <i class="fas fa-circle f-10" style="color: #fff; margin-right: 6px;"></i>182
              </h3>
              <span style="font-size: 13px; color: #fff;">Return</span>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- 3. Baris Social Cards & Activity Feed -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Kolom Kiri: 2 Social Cards (4 Kolom) -->
    <div class="lg:col-span-4 flex flex-col gap-6">
      
      <!-- Social Card 1: Subscribers -->
      <div class="card social-card">
        <div class="card-body">
          <i class="d-block f-40 text-c-blue fa fa-envelope-open" style="display: block; margin-bottom: 15px;"></i>
          <h4 class="m-t-20" style="font-size: 20px; font-weight: 600; margin-bottom: 8px;">
            <span class="text-c-blue">8.62k</span> Subscribers
          </h4>
          <p class="m-b-20" style="color: #888; font-size: 13px; margin-bottom: 20px;">
            Your main list is growing
          </p>
          <a href="{{ route('admin.users') }}" class="btn-primary-custom">
            Manage List
          </a>
        </div>
      </div>

      <!-- Social Card 2: Followers -->
      <div class="card social-card">
        <div class="card-body">
          <i class="d-block f-40 text-c-green fab fa-twitter" style="display: block; margin-bottom: 15px;"></i>
          <h4 class="m-t-20" style="font-size: 20px; font-weight: 600; margin-bottom: 8px;">
            <span class="text-c-green">+40</span> Followers
          </h4>
          <p class="m-b-20" style="color: #888; font-size: 13px; margin-bottom: 20px;">
            Your main list is growing
          </p>
          <a href="{{ route('admin.konfigurasi') }}" class="btn-success-custom">
            Check them out
          </a>
        </div>
      </div>

    </div>

    <!-- Kolom Kanan: Activity Feed (8 Kolom) -->
    <div class="lg:col-span-8">
      <div class="card">
        <div class="card-header">
          <h5>Activity Feed</h5>
        </div>
        <div class="card-body" style="padding-top: 25px;">
          <ul class="feed-blog ps-0">
            
            <!-- Feed Item 1: Eddie -->
            <li class="active-feed">
              <div class="feed-user-img">
                <img src="{{ asset('images/user/avatar-1.jpg') }}" class="img-radius" alt="User-Profile" />
              </div>
              <h6>
                <span class="badge-custom bg-danger-custom">File</span> Eddie uploaded new files:
                <small style="color: #888; font-weight: 400; font-size: 12px; margin-left: 5px;">2 hours ago</small>
              </h6>
              <p style="color: #666; font-size: 13px; line-height: 1.6; margin: 12px 0 15px 0;">
                hii <b>@everone</b> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
              </p>
              <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <div style="text-align: center;">
                  <img src="{{ asset('images/gallery-grid/img-grd-gal-1.jpg') }}" alt="Old Scooter" class="wid-100" />
                  <h6 style="margin-top: 10px; margin-bottom: 2px; font-size: 13px; font-weight: 600;">Old Scooter</h6>
                  <p style="color: #888; margin: 0; font-size: 11px;">PNG-100KB</p>
                </div>
                <div style="text-align: center;">
                  <img src="{{ asset('images/gallery-grid/img-grd-gal-2.jpg') }}" alt="Wall Art" class="wid-100" />
                  <h6 style="margin-top: 10px; margin-bottom: 2px; font-size: 13px; font-weight: 600;">Wall Art</h6>
                  <p style="color: #888; margin: 0; font-size: 11px;">PNG-150KB</p>
                </div>
                <div style="text-align: center;">
                  <img src="{{ asset('images/gallery-grid/img-grd-gal-3.jpg') }}" alt="Microphone" class="wid-100" />
                  <h6 style="margin-top: 10px; margin-bottom: 2px; font-size: 13px; font-weight: 600;">Microphone</h6>
                  <p style="color: #888; margin: 0; font-size: 11px;">PNG-150KB</p>
                </div>
              </div>
            </li>

            <!-- Feed Item 2: Sarah -->
            <li class="diactive-feed">
              <div class="feed-user-img">
                <img src="{{ asset('images/user/avatar-1.jpg') }}" class="img-radius" alt="User-Profile" />
              </div>
              <h6>
                <span class="badge-custom bg-success-custom">Task</span> Sarah marked the Pending Review:
                <span class="text-c-green" style="margin-left: 4px;">Trash Can Icon Design</span>
                <small style="color: #888; font-weight: 400; font-size: 12px; margin-left: 5px;">2 hours ago</small>
              </h6>
            </li>

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
    // 1. Unique Visitor Line Chart
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
        categories: ['15 Jan', "Feb '00", '15 Feb', "Mar '00", '15 Mar', "Apr '00", '15 Apr', "May '00", '15 May', "Jun '00"],
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
        min: 10,
        max: 70,
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
          name: 'Arts',
          data: [20, 50, 30, 60, 30, 50]
        },
        {
          name: 'Commerce',
          data: [60, 30, 65, 45, 67, 35]
        }
      ]
    };
    var chart1 = new ApexCharts(document.querySelector("#unique-visitor-chart"), uniqueVisitorOptions);
    chart1.render();

    // 2. Customer Donut Chart (White Card)
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
      labels: ['New', 'Return'],
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
      series: [674, 182]
    };
    var chart2 = new ApexCharts(document.querySelector("#customer-chart"), customerChartOptions);
    chart2.render();

    // 3. Customer Donut Chart 1 (Blue Card)
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
      labels: ['New', 'Return'],
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
      series: [674, 182]
    };
    var chart3 = new ApexCharts(document.querySelector("#customer-chart-1"), customerChart1Options);
    chart3.render();
  });
</script>
@endpush
