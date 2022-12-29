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
    <form action="{{ url($button->formEdit('Departemen / Divisi'), ['id' => $data->id]) }}" method="post">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama</label>
          <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" required value="{{ $data->nama }}">
          <input type="hidden" name="id" value="{{ $data->id }}">
          @error('nama')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Kategori</label>
          <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
            <option value="">--Pilih Kategori--</option>
            <option value="1" {{ $data['kategori'] == '1' ? 'selected' : '' }}>Departemen</option>
            <option value="2" {{ $data['kategori'] == '2' ? 'selected' : '' }}>Divisi</option>
          </select>
          @error('kategori')
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