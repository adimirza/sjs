@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section profile">
  <div class="row">
    <div class="col-xl-4">
      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
          <img src="{{ url('upload/image/profil') }}{{auth()->user()->foto ? '/'.auth()->user()->foto : '/person-icon.png'}}" alt="Profile" class="rounded-circle">
          <h2>{{ auth()->user()->name }}</h2>
          <h3>{{ auth()->user()->jabatan->nama }} - {{ auth()->user()->departemen->nama }}</h3>
          @if(auth()->user()->status == '1')
            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Aktif</span>
          @else
            <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Non Aktif</span>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-4">
      <div class="card">
        <div class="card-body profile-card  d-flex flex-column align-items-left">
          <h5 class="card-title">Statistik Anggota</h5>
          <p>Statistik Surat Edaran yang sudah tuntas dipahami anggota</p>
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{ ($jml_paham_umum/$jml_umum)*100 }}%" aria-valuenow="{{ $jml_paham_umum }}" aria-valuemin="0" aria-valuemax="100">{{ $jml_paham_umum }}/{{ $jml_umum }}</div>
          </div>
          <p>SE Umum</p>
          <div class="progress mt-3">
            <div class="progress-bar" role="progressbar" style="width: {{ ($jml_paham_divisi/$jml_divisi)*100 }}%" aria-valuenow="{{ $jml_paham_divisi }}" aria-valuemin="0" aria-valuemax="100">{{ $jml_paham_divisi }}/{{ $jml_divisi }}</div>
          </div>
          <p>SE Divisi</p>
        </div>
      </div>
    </div>
    <div class="col-xxl-4 col-md-4">
      <div class="card info-card customers-card">
        <div class="card-body">
          <h5 class="card-title">Pelanggaran </h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-x-circle-fill"></i>
            </div>
            <div class="ps-3">
              <h6>{{ auth()->user()->jumlah_teguran(auth()->user()->id)['pelanggaran'] }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xxl-4 col-md-4">
      <div class="card info-card customers-card">
        <div class="card-body">
          <h5 class="card-title">Teguran </h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-exclamation-circle-fill"></i>
            </div>
            <div class="ps-3">
              <h6>{{ auth()->user()->jumlah_teguran(auth()->user()->id)['teguran'] }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection