@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tabel {{ $title }}</h3>
      <form action="{{ url('kotak_masuk') }}" method="GET">
        <div class="row">
          <div class="col-3">
            <select name="bulan" class="form-select" aria-label="Default select example" required>
              <option value="">--Pilih Bulan--</option>
              @for($bln = 1; $bln <= 12; $bln++)
              <option {{ $bulan == $bln ? 'selected' : '' }} value="{{ $bln }}">{{ $lib->bulan[$bln] }}</option>
              @endfor
            </select>
          </div>
          <div class="col-3">
            <select class="form-select" name="tahun" aria-label="Default select example" required>
              <option value="">--Pilih Tahun--</option>
              @php 
              $awal = 2022;
              $akhir = intval(date('Y')+3);
              @endphp
              @for($thn = $awal; $thn <= $akhir; $thn++)
              <option {{ $tahun == $thn ? 'selected' : '' }} value="{{ $thn }}">{{ $thn }}</option>
              @endfor
            </select>
          </div>
          <div class="col-1">
            <button type="submit" class="btn btn-primary">Pilih</button>
          </div>
        </div>
      </form> <br>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table class="table table-borderless datatable">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Keterangan Topik</th>
            <th scope="col">Nomor Surat</th>
            <th scope="col">Ditujukan</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @php
          $i=1;
          @endphp
          @foreach($data as $dt)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $dt['keterangan_topik'] }}</td>
            <td>{{ $dt['nomor_surat'] }}</td>
            <td>{{ $dt['ditujukan'] == 0 ? 'Umum' : $dt->departemen->nama }}</td>
            <td>{!! $dt->ket_status($dt['id'], $dt['status']) !!}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection