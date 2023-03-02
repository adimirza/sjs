@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Form Tambah</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h5><i class="icon fas fa-exclamation-triangle"></i> Fail!</h5>
      {{ session('error') }}
    </div>
    @endif
    <form action="{{ url($button->formAdd($title)) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
      <div class="form-group">
        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Kategori</label>
        <div class="col-md-12 col-lg-12">
          <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" aria-label="Default select example">
            <option>--Pilih Kategori--</option>
            <option {{ old('kategori') == 1 ? 'selected' : '' }} value="1">Online</option>
            <option {{ old('kategori') == 0 ? 'selected' : '' }} value="0">Offline</option>
          </select>
          @error('kategori')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 col-lg-3 col-form-label">Judul Rapat</label>
        <div class="col-md-12 col-lg-12">
          <textarea name="judul" class="form-control @error('judul') is-invalid @enderror">{{ old('judul') }}</textarea>
          @error('judul')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="form-group">
        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Departemen/Divisi</label>
        <div class="col-md-12 col-lg-12">
          <select name="id_departemen" class="form-select @error('id_departemen') is-invalid @enderror" aria-label="Default select example">
            <option>--Pilih Departemen/Divisi--</option>
            <option value="0">Semua / Umum</option>
            @foreach($departemen as $dep)
            <option {{ $dep['id'] == old('id_departemen') ? 'selected' : '' }} value="{{ $dep['id'] }}">{{ $dep->nama }}</option>
            @endforeach
          </select>
          @error('id_departemen')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="form-group">
        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Person in Charge</label>
        <div class="col-md-12 col-lg-12">
          <select name="id_users" class="form-select @error('id_users') is-invalid @enderror" aria-label="Default select example">
            <option>--Pilih PIC--</option>
            @foreach($user as $usr)
            <option {{ $usr['id'] == old('id_users') ? 'selected' : '' }} value="{{ $usr['id'] }}">{{ $usr['name'].' - '.$usr->jabatan->nama.' '.$usr->departemen->nama }}</option>
            @endforeach
          </select>
          @error('id_users')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 col-lg-3 col-form-label">Tanggal Rapat</label>
        <div class="col-md-12 col-lg-12">
          <input name="tanggal" id="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
          @error('tanggal')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 col-lg-3 col-form-label">Waktu Mulai</label>
        <div class="col-md-12 col-lg-12">
          <input name="waktu_mulai" type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" value="{{ old('waktu_mulai') }}">
          @error('waktu_mulai')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 col-lg-3 col-form-label">Waktu Akhir</label>
        <div class="col-md-12 col-lg-12">
          <input name="waktu_akhir" type="time" class="form-control @error('waktu_akhir') is-invalid @enderror" value="{{ old('waktu_akhir') }}">
          @error('waktu_akhir')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 col-lg-3 col-form-label">Link</label>
        <div class="col-md-12 col-lg-12">
          <textarea name="link" class="form-control @error('link') is-invalid @enderror">{{ old('link') }}</textarea>
          @error('link')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      </div>
      <div class="card-footer">
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </form><!-- End Profile Edit Form -->
  </div>
</section>
@endsection
@section('footlib_req')
<script>
  $(function(){
    var dtToday = new Date();
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#tanggal').attr('min', maxDate);
  });
</script>
@endsection