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
    <form action="{{ url($button->formEdit('Pegawai'), ['id' => $data->id]) }}" method="post">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama</label>
          <input type="text" name="name" class="form-control" required value="{{ $data->name }}">
          <input type="hidden" name="id" value="{{ $data->id }}">
          @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ $data->email }}">
          @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Role</label>
          <select name="id_role" class="form-control @error('id_role') is-invalid @enderror" required>
            <option value="">--Pilih Role--</option>
            @foreach($role as $rl)
            <option value="{{ $rl['id'] }}" {{ $data['id_role'] == $rl['id'] ? 'selected' : '' }}>{{ $rl['nama'] }}</option>
            @endforeach
          </select>
          @error('id_role')
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