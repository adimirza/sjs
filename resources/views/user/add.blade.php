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
    <form action="{{ url($button->formAdd('Pegawai')) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
        <div class="row mb-3">
          <label class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
          <div class="col-md-8 col-lg-9">
            <input name="foto" type="file" class="form-control @error('foto') is-invalid @enderror" value="{{ old('foto') }}">
            @error('foto')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
          <div class="col-md-8 col-lg-9">
            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-md-4 col-lg-3 col-form-label">Username</label>
          <div class="col-md-8 col-lg-9">
            <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
            @error('username')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-md-4 col-lg-3 col-form-label">ID</label>
          <div class="col-md-8 col-lg-9">
            <input name="id_pegawai" type="text" class="form-control @error('id_pegawai') is-invalid @enderror" value="{{ old('id_pegawai') }}">
            @error('id_pegawai')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
          <div class="col-md-8 col-lg-9">
            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" aria-label="Default select example">
              <option>Pilih Jenis Kelamin</option>
              <option {{ old('jenis_kelamin') == '1' ? 'selected' : '' }} value="1">Laki-laki</option>
              <option {{ old('jenis_kelamin') == '0' ? 'selected' : '' }} value="0">Perempuan</option>
            </select>
            @error('jenis_kelamin')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Tempat Lahir</label>
          <div class="col-md-8 col-lg-9">
            <input name="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
            @error('tempat_lahir')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputDate" class="col-md-4 col-lg-3 col-form-label">Tanggal Lahir</label>
          <div class="col-md-8 col-lg-9">
            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
            @error('tanggal_lahir')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Departemen/Divisi</label>
          <div class="col-md-8 col-lg-9">
            <select name="id_departemen" class="form-select @error('id_departemen') is-invalid @enderror" aria-label="Default select example">
              <option>--Pilih Departemen/Divisi--</option>
              @foreach($departemen as $dep)
              <option {{ $dep['id'] == old('id_departemen') ? 'selected' : '' }} value="{{ $dep['id'] }}">{{ $dep['nama'] }}</option>
              @endforeach
            </select>
            @error('id_departemen')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Jabatan</label>
          <div class="col-md-8 col-lg-9">
            <select name="id_jabatan" class="form-select @error('id_jabatan') is-invalid @enderror" aria-label="Default select example">
              <option>--Pilih Jabatan--</option>
              @foreach($jabatan as $jab)
              <option {{ $jab['id'] == old('id_jabatan') ? 'selected' : '' }} value="{{ $jab['id'] }}">{{ $jab['nama'] }}</option>
              @endforeach
            </select>
            @error('id_jabatan')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Nomor Handphone</label>
          <div class="col-md-8 col-lg-9">
            <input name="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}">
            @error('no_hp')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
          <div class="col-md-8 col-lg-9">
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="Address" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
          <div class="col-md-8 col-lg-9">
            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" style="height: 100px">{{ old('alamat') }}</textarea>
            @error('alamat')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Status</label>
          <div class="col-md-8 col-lg-9">
            <select name="status" class="form-select @error('status') is-invalid @enderror" aria-label="Default select example">
              <option>Pilih Status</option>
              <option {{ old('status') == '1' ? 'selected' : '' }} value="1">Aktif</option>
              <option {{ old('status') == '0' ? 'selected' : '' }} value="0">Non-Aktif</option>
            </select>
            @error('status')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <h4>Info Kontrak</h4>
        <div class="row mb-3">
          <label for="inputDate" class="col-md-4 col-lg-3 col-form-label">Tanggal Masuk</label>
          <div class="col-md-8 col-lg-9">
            <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}">
            @error('tanggal_masuk')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputDate" class="col-md-4 col-lg-3 col-form-label">Tanggal Berakhir</label>
          <div class="col-md-8 col-lg-9">
            <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}">
            @error('tanggal_berakhir')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form><!-- End Profile Edit Form -->
  </div>
</section>
@endsection