@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Form Edit</h3>
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
    <form action="{{ url($button->formEdit('Teguran'), ['id' => $data->id]) }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Tanggal</label>
          <input type="hidden" name="id_users" value="{{ $data->id_users }}">
          <input type="hidden" name="id" value="{{ $data->id }}">
          <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" required value="{{ $data->tanggal }}">
          @error('tanggal')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Kategori</label>
          <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
            <option value="">--Pilih Kategori--</option>
            <option {{ $data->kategori == '0' ? 'selected' : '' }} value="0">Teguran</option>
            <option {{ $data->kategori == '1' ? 'selected' : '' }} value="1">Pelanggaran</option>
          </select>
          @error('kategori')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Keterangan</label>
          <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" required>{{ $data->keterangan }}</textarea>
          @error('keterangan')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Ganti File Surat</label>
          <input type="hidden" name="file_surat_old" value="{{ $data->file_surat }}">
          <input type="file" name="file_surat" class="form-control @error('file_surat') is-invalid @enderror">
          @error('file_surat')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</section>
@endsection