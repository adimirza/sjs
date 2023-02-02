@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section">
  @if(session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Fail!</strong>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body pt-4">
            <img src="{{$data->foto ? url('upload/image/tugas').'/'.$data->foto : asset('/assets/img/no-image.png') }}" width="100%">
          </div>
          <div class="card-footer text-center">
            <span><button class="btn btn-info" data-bs-target="#upload_foto" data-bs-toggle="modal">Upload Foto</button></span>
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview">Detail</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit">Sunting</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#catatan">Catatan</button>
              </li>
            </ul>
            <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" id="overview">
                <h5 class="card-title">Detail Tugas</h5>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Nama Staff</div>
                  <div class="col-lg-9 col-md-8">{{ $data->user->name }} - {{ $data->user->jabatan->nama }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Departemen/Divisi</div>
                  <div class="col-lg-9 col-md-8">{{ $data->user->departemen->nama }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Nama Customer</div>
                  <div class="col-lg-9 col-md-8">{{ $data->nama_customer }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Deskripsi Tugas</div>
                  <div class="col-lg-9 col-md-8">{{ $data->deskripsi }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Tanggal</div>
                  <div class="col-lg-9 col-md-8">{{ date('d F Y', strtotime($data->tanggal)) }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Waktu</div>
                  <div class="col-lg-9 col-md-8">{{ date('H:i', strtotime($data->tanggal)) }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Lokasi</div>
                  <div class="col-lg-9 col-md-8">{{ $data->lokasi }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Catatan</div>
                  <div class="col-lg-9 col-md-8">{{ $data->catatan }}</div>
                </div>
              </div>
              <div class="tab-pane fade profile-edit pt-3" id="edit">
                <form action="{{ url($button->formEdit($title)) }}" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $data->id }}">
                  @if(auth()->user()->jabatan->role->nama != 'Member')
                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Departemen/Divisi</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="id_departemen" class="form-select @error('id_departemen') is-invalid @enderror" aria-label="Default select example" id="iddepartemen">
                        <option>--Pilih Departemen/Divisi--</option>
                        @foreach($departemen as $dep)
                        <option {{ $dep['id'] == $data->user->id_departemen ? 'selected' : '' }} value="{{ $dep['id'] }}">{{ $dep->nama }}</option>
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
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Nama Staff</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="id_users" class="form-select @error('id_users') is-invalid @enderror" aria-label="Default select example" id="iduser">
                        <option>--Pilih Pegawai--</option>
                      </select>
                      @error('id_users')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  @else
                  <input type="hidden" name="id_users" value="{{ auth()->user()->id }}">
                  @endif
                  <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Nama Customer</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="nama_customer" class="form-control @error('nama_customer') is-invalid @enderror" value="{{ $data->nama_customer }}">
                      @error('nama_customer')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Deskripsi Tugas</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ $data->deskripsi }}</textarea>
                      @error('deskripsi')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputDate" class="col-md-4 col-lg-3 col-form-label">Tanggal</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="tanggal" type="datetime-local" class="form-control @error('tanggal') is-invalid @enderror" value="{{ $data->tanggal }}">
                      @error('tanggal')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Lokasi</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="lokasi" class="form-control @error('lokasi') is-invalid @enderror">{{ $data->lokasi }}</textarea>
                      @error('lokasi')
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
                        <option {{$data->status == 0 ? 'selected' : ''}} value="0">Belum Dikerjakan</option>
                        <option {{$data->status == 1 ? 'selected' : ''}} value="1">Sedang Dikerjakan</option>
                        <option {{$data->status == 2 ? 'selected' : ''}} value="2">Sudah Dikerjakan</option>
                      </select>
                      @error('status')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                  </div>
                </form><!-- End Profile Edit Form -->
              </div>
              <div class="tab-pane fade pt-3" id="catatan">
                <form action="{{ url($button->formEtc($title).'/edit_catatan') }}" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $data->id }}">
                  <div class="card">
                    <div class="card-header">
                      Catatan Kegiatan
                    </div>
                    <div class="card-body mt-3">
                      <textarea name="catatan" class="form-control">{{ $data->catatan }}</textarea>
                    </div>
                    <div class="card-footer text-center">
                      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                  </div>
                </form>
              </div>
            </div><!-- End Bordered Tabs -->
          </div>
        </div>
      </div>
    </div>
  </section>
</section>
<div class="modal fade" id="upload_foto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Foto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url($button->formEtc($title)).'/edit_foto' }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <input type="file" name="foto" class="form-control" required>
            <input name="id" type="hidden" value="{{ $data->id }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('footlib_req')
<script src="{{ url('/assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    getuser('{{ $data->user->id_departemen }}', '{{ $data->id_users }}');
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
        var html = '<option value="">--Pilih Staff--</option>';
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