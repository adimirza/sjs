@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section dashboard">
  <div class="row">
    <!-- Main side columns -->
    <div class="col-md-12 card">
      <div class="card-body">
        <form action="{{ url($cont->button->formEtc('Dashboard')) }}" method="GET" class="d-inline">
          <div class="row mt-4">
            <div class="col-4">
              <select class="form-select" name="tahun" aria-label="Default select example">
                <option value="">--Pilih Tahun--</option>
                @for($i=2022;$i<=date('Y')+5;$i++)
                <option {{ $tahun == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>
            <div class="col-4">
              <select class="form-select" name="bulan" aria-label="Default select example">
                <option value="">--Pilih Bulan--</option>
                @for($b=1;$b<=12;$b++)
                <option {{ $bulan == $b ? 'selected' : '' }} value="{{ $b }}">{{ $cont->lib->bulan[$b] }}</option>
                @endfor
              </select>
            </div>
            <div class="col-1">
              <button type="submit" class="btn btn-primary">Pilih</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="row">
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Jumlah Surat Edaran</h5>
              <div class="d-flex align-items-center">
                <div class="flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>{{ $jml_umum+$jml_khusus }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Sales Card -->
        <!-- Revenue Card -->

        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">
            <div class="card-body">

              <h5 class="card-title">SE Umum</h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>{{ $jml_umum }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Revenue Card -->
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">SE Khusus</h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>{{ $jml_khusus }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Sales Card -->
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Jumlah Staff<br> <span> Tahun ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>{{ $jml_staff }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Sales Card -->
        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Staff paham SE <br><span> Bulan ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>{{ $jml_paham }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Revenue Card -->
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Staaf belum paham SE<br><span> Tahun ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>{{ ($jml_umum+$jml_khusus)-$jml_paham }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Revenue Card -->
        @foreach($departemen as $dep)
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">{{ $dep->nama }}</h5>
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center">
                </div>
                <div class="ps-3">
                  <h6>{{ $cont->getJmlDepartemen($dep->id) }} pegawai</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <!-- <div class="col-xxl-6 col-md-6">
          <div class="card info-card revenue-card">
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
        </div> -->
        <!-- Revenue Card -->
        <!-- <div class="col-xxl-6 col-md-6">
          <div class="card info-card revenue-card">
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
        </div> -->
      </div>
    </div>
  </div>
</section>
@endsection