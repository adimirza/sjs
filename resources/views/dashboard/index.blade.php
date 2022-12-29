@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section dashboard">
  <div class="row">
    <!-- Main side columns -->
    <div class="col-lg-12">
      <div class="row">
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Hari ini</a></li>
                <li><a class="dropdown-item" href="#">Bulan ini</a></li>
                <li><a class="dropdown-item" href="#">Tahun ini</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Jumlah Surat Edaran<br> <span> Tahun ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>30</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Sales Card -->
        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Hari ini</a></li>
                <li><a class="dropdown-item" href="#">Bulan ini</a></li>
                <li><a class="dropdown-item" href="#">Tahun ini</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">SE Umum <br><span> Bulan ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>75</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Revenue Card -->
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Hari ini</a></li>
                <li><a class="dropdown-item" href="#">Bulan ini</a></li>
                <li><a class="dropdown-item" href="#">Tahun ini</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">SE Khusus<br><span> Tahun ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>0</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Sales Card -->
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Hari ini</a></li>
                <li><a class="dropdown-item" href="#">Bulan ini</a></li>
                <li><a class="dropdown-item" href="#">Tahun ini</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Jumlah Staff<br> <span> Tahun ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>250</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Sales Card -->
        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Hari ini</a></li>
                <li><a class="dropdown-item" href="#">Bulan ini</a></li>
                <li><a class="dropdown-item" href="#">Tahun ini</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Staff paham SE <br><span> Bulan ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>75</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Revenue Card -->
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Hari ini</a></li>
                <li><a class="dropdown-item" href="#">Bulan ini</a></li>
                <li><a class="dropdown-item" href="#">Tahun ini</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Staaf belum paham SE<br><span> Tahun ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>0</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Revenue Card -->
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card revenue-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Hari ini</a></li>
                <li><a class="dropdown-item" href="#">Bulan ini</a></li>
                <li><a class="dropdown-item" href="#">Tahun ini</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Jabatan Staff Komplit<br><span>Bulan ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>25</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Revenue Card -->
        <!-- Revenue Card -->
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card revenue-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Hari ini</a></li>
                <li><a class="dropdown-item" href="#">Bulan ini</a></li>
                <li><a class="dropdown-item" href="#">Tahun ini</a></li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Jabatan Staff belum komplit<br><span>Tahun ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>50</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection