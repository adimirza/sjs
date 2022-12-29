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
    <form action="{{ url($button->formAdd('Menu')) }}" method="post">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Heading</label>
          <select name="id_heading" class="form-control @error('id_heading') is-invalid @enderror">
            <option value="0">--Pilih Heading--</option>
            @foreach($heading as $head)
            <option value="{{ $head['id'] }}">{{ $head['nama_heading'] }}</option>
            @endforeach
          </select>
          @error('id_heading')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Parent</label>
          <select name="parent" class="form-control @error('parent') is-invalid @enderror">
            <option value="">--Pilih Parent--</option>
            @foreach($parent as $pr)
            <option value="{{ $pr['id'] }}">{{ $pr['nama'] }}</option>
            @endforeach
          </select>
          @error('parent')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Nama Menu</label>
          <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" required value="{{ old('nama') }}">
          @error('nama')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">URL</label>
          <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" required value="{{ old('url') }}">
          @error('url')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">URI</label>
          <input type="text" name="uri" class="form-control @error('uri') is-invalid @enderror" value="{{ old('uri') }}">
          @error('uri')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Icon</label>
          <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon') }}">
          <labe><a href="https://icons.getbootstrap.com/" target="_blank">Referensi</a></labe>
          @error('icon')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Urutan</label>
          <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" required value="{{ old('urutan') }}">
          @error('urutan')
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