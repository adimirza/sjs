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
    <form action="{{ url($button->formEdit('Atribut'), ['id' => $data->id]) }}" method="post">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Atribut</label>
          <input type="text" name="atribut" class="form-control @error('atribut') is-invalid @enderror" required value="{{ $data->atribut }}">
          <input type="hidden" name="id" value="{{ $data->id }}">
          @error('atribut')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Status</label>
          <select name="status" class="form-control @error('status') is-invalid @enderror" required>
            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
          @error('atribut')
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