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
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Departemen/Divisi</label>
          <div class="col-md-12 col-lg-12">
            <select name="id_departemen" class="form-select @error('id_departemen') is-invalid @enderror" aria-label="Default select example" id="iddepartemen">
              <option>--Pilih Departemen/Divisi--</option>
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
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Nama Staff</label>
          <div class="col-md-12 col-lg-12">
            <select name="id_users" class="form-select @error('id_users') is-invalid @enderror" aria-label="Default select example" id="iduser">
              <option>--Pilih PIC--</option>
            </select>
            @error('id_users')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 col-lg-3 col-form-label">Deskripsi Tugas</label>
          <div class="col-md-12 col-lg-12">
            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 col-lg-3 col-form-label">Tanggal</label>
          <div class="col-md-12 col-lg-12">
            <input name="tanggal" type="datetime-local" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
            @error('tanggal')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 col-lg-3 col-form-label">Lokasi</label>
          <div class="col-md-12 col-lg-12">
            <textarea name="lokasi" class="form-control @error('lokasi') is-invalid @enderror">{{ old('lokasi') }}</textarea>
            @error('lokasi')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Status</label>
          <div class="col-md-12 col-lg-12">
            <select name="status" class="form-select @error('status') is-invalid @enderror" aria-label="Default select example">
              <option value="0">Belum Dikerjakan</option>
              <option value="1">Sedang Dikerjakan</option>
              <option value="2">Sudah Dikerjakan</option>
            </select>
            @error('status')
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
  $(document).ready(function() {
    getuser('{{ old("id_departemen") }}', '{{ old("id_users") }}');
    $("#iddepartemen").change(function() {
      var id = $('#iddepartemen').val();
      var iduser = '';
      getuser(id, iduser);
    });
  });

  function getuser(iddepartemen, iduser) {
    $.ajax({
      url: "{{ url($button->formEtc('Tugas').'/getdata') }}",
      data: {
        "id": iddepartemen,
      },
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        var html = '<option value="">--Pilih PIC--</option>';
        var i;
        for (i = 0; i < data.length; i++) {
          if (iduser == data[i].id) {
            html += '<option selected value=' + data[i].id + '>' + data[i].name + '</option>';
          } else {
            html += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
          }
        }
        $('#iduser').html(html);
      }
    })
  }
</script>
@endsection