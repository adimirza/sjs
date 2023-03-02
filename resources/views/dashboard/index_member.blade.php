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
    <div class="col-xl-8">
      <div class="card">
        <div class="card-body profile-card  d-flex flex-column align-items-left">
          <h5 class="card-title">Statistik Anggota</h5>
          <p>Statistik Surat Edaran yang sudah tuntas dipahami anggota</p>
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{ $jml_umum ? ($jml_paham_umum/$jml_umum)*100 : '0' }}%" aria-valuenow="{{ $jml_paham_umum }}" aria-valuemin="0" aria-valuemax="100">SE Umum {{ $jml_paham_umum }}/{{ $jml_umum }}</div>
          </div>
          <div class="progress mt-3">
            <div class="progress-bar" role="progressbar" style="width: {{ $jml_umum ? ($jml_paham_divisi/$jml_divisi)*100 : 0 }}%" aria-valuenow="{{ $jml_paham_divisi }}" aria-valuemin="0" aria-valuemax="100">SE Divisi {{ $jml_paham_divisi }}/{{ $jml_divisi }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="card-title mb-3">Agenda Rapat <small class="text-muted">{{ $cont->lib->hari[date('D', strtotime($tgl))] }}, {{ $cont->lib->forTanggal($tgl) }}</small></h5>
        </div>
        <div class="card-body mt-3">
          <div class="mb-3">
            <form action="{{ url($cont->button->formEtc('Dashboard')) }}" method="GET" class="d-inline">
              <div class="input-group">
                <input type="date" name="tanggal" class="form-control" id="tanggal-rapat">
                <input type="hidden" name="bulan" class="form-control" value="{{ $bulan }}">
                <input type="hidden" name="tahun" class="form-control" value="{{ $tahun }}">
                <button class="btn btn-primary" type="submit">Pilih Tanggal</button>
              </div>
            </form>
          </div>
          <div class="activity">
            @foreach($rapat as $rpt)
            <div class="activity-item d-flex">
              <div class="activity-label">{{ date('d-M-Y', strtotime($rpt->tanggal)) }} | {{ date('H:i', strtotime($rpt->waktu_mulai)) }} &nbsp;&nbsp;</div>
              <i class="bi bi-circle-fill activity-badge text-{{ $rpt->status($rpt->id)['class'] }} align-self-start"></i>
              <div class="activity-content bg-{{ $rpt->status($rpt->id)['class'] }}"><a href="#" class="fw-bold text-white">{{ $rpt->judul.' ('.$rpt->status($rpt->id)['keterangan'].')' }}</a></div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 card">
      <div class="card-body">
        <form action="{{ url($cont->button->formEtc('Dashboard')) }}" method="GET" class="d-inline">
          <div class="row mt-4">
            <div class="col-4">
              <input type="hidden" name="tanggal" class="form-control" value="{{ $tgl }}">
              <select class="form-select" name="tahun" aria-label="Default select example">
                <option value="">--Pilih Tahun--</option>
                @for($i=2022;$i<=date('Y')+5;$i++) <option {{ $tahun == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                  @endfor
              </select>
            </div>
            <div class="col-4">
              <select class="form-select" name="bulan" aria-label="Default select example">
                <option value="">--Pilih Bulan--</option>
                @for($b=1;$b<=12;$b++) <option {{ $bulan == $b ? 'selected' : '' }} value="{{ $b }}">{{ $cont->lib->bulan[$b] }}</option>
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
    <div class="col-12">
      <div class="card card-calendar">
        <div class="card-header">
          <h5 class="card-title mb-0">Kalender Kunjungan</h5>
        </div>
        <div class="card-body mt-3">
          <div class="row">
            @foreach($tugas as $tgs)
            <div class="col-md-3">
              <div class="card">
                <div class="card-body">
                  <h6 class="card-title"><span>{{ $cont->lib->hari[date('D', strtotime($tgs->tanggal))] }}</span><br>{{ $cont->lib->forTanggal(date('Y-m-d', strtotime($tgs->tanggal))) }}</h6>
                  <ul class="list-unstyled">
                    @php
                    $dt_tugas = $data_tugas->whereRaw("DATE(tanggal) = '$tgs->tanggal'")->get();
                    @endphp
                    <table class="table table-striped" style="font-size: small;">
                    @foreach($dt_tugas as $dt)
                      <tr>
                        <td><small>{{ $dt->user->name }}</small></td>
                        <td><small>{{ $dt->deskripsi }}</small></td>
                      </tr>
                    <!-- <li><a href="#" class="text-dark" style="background-color: #F8D7DA;">{{ $dt->user->name }}:{{ $dt->deskripsi }} </a> </li> -->
                    @endforeach
                    </table>
                    <!-- <li><a href="#" class="text-dark" style="background-color: #D4EDDA;">Andy: Kunjungan ke Bandung</a></li> -->
                  </ul>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
</section>
@endsection