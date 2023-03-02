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
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-6 mb-4">
          <div class="card">
            <div class="card-header">
              <h6 class="text-uppercase mb-0">Surat Edaran</h6>
            </div>
            <div class="card-body">
              <div class="chart-pie pt-4">
                <canvas id="myPieChart"></canvas>
              </div>
              <div class="mt-4 text-center small d-flex justify-content-center flex-wrap">
                <span class="me-3">
                  <i class="bi bi-circle-fill text-primary"></i> Surat Edaran Umum ({{ $jml_umum }})
                </span>
                <span class="me-3">
                  <i class="bi bi-circle-fill text-success"></i> Surat Edaran Khusus ({{ $jml_khusus }})
                </span>
                <span class="me-3">
                  <i class="bi bi-circle-fill text-info"></i> Total Surat Edaran ({{ $jml_umum + $jml_khusus }})
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mb-4">
          <div class="card">
            <div class="card-header">
              <h6 class="text-uppercase mb-0">Pemahaman SE Staff</h6>
            </div>
            <div class="card-body">
              <div class="chart-pie pt-4">
                <canvas id="pemahamanSEStaffChart"></canvas>
              </div>
              <div class="mt-4 text-center small d-flex justify-content-center flex-wrap">
                <span class="me-3">
                  <i class="bi bi-circle-fill text-primary"></i> Paham SE ({{ $jml_paham }})
                </span>
                <span class="me-3">
                  <i class="bi bi-circle-fill text-danger"></i> Belum Paham SE ({{ $jml_staff-$jml_paham }})
                </span>
                <span class="me-3">
                  <i class="bi bi-circle-fill text-info"></i> Total Staff ({{ $jml_staff }})
                </span>
              </div>
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
  </div>
</section>
@endsection
@section('footlib_req')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var data = {
    labels: ["Surat Edaran Umum", "Surat Edaran Khusus"],
    datasets: [{
      data: [{{ $jml_umum }}, {{ $jml_khusus }}],
      backgroundColor: ["#007bff", "#28a745"],
    }, ],
  };

  var options = {
    maintainAspectRatio: false,
    legend: {
      display: true,
      position: "bottom",
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: "#dddfeb",
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    cutoutPercentage: 80,
  };
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: "pie",
    data: data,
    options: options,
  });
</script>
<script>
  var data = {
    labels: ["Paham SE", "Belum Paham SE"],
    datasets: [{
      data: [{{ $jml_paham }}, {{ ($jml_staff) - $jml_paham }}],
      backgroundColor: ["#007bff", "#dc3545"],
    }, ],
  };

  var options = {
    maintainAspectRatio: false,
    legend: {
      display: true,
      position: "bottom",
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: "#dddfeb",
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    cutoutPercentage: 80,
  };

  var ctx = document.getElementById("pemahamanSEStaffChart");
  var myPieChart = new Chart(ctx, {
    type: "pie",
    data: data,
    options: options,
  });
</script>
@endsection