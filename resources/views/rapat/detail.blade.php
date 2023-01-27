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
            <img src="{{ url('upload/image/rapat') }}{{$data->foto ? '/'.$data->foto : '/person-icon.png'}}" width="100%">
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
                <h5 class="card-title">Detail Rapat</h5>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Kategori</div>
                  <div class="col-lg-9 col-md-8">{{ $data->kategori ? 'Online' : 'Offline' }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Judul Rapat</div>
                  <div class="col-lg-9 col-md-8">{{ $data->judul }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Departemen/Divisi</div>
                  <div class="col-lg-9 col-md-8">{{ $data->id_departemen ? $data->departemen->nama : 'Umum' }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">PIC</div>
                  <div class="col-lg-9 col-md-8">{{ $data->user->name }} - {{ $data->user->jabatan->nama.' '.$data->user->departemen->nama }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Tanggal Rapat</div>
                  <div class="col-lg-9 col-md-8">{{ date('d F Y', strtotime($data->tanggal)) }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Waktu</div>
                  <div class="col-lg-9 col-md-8">{{ $data->waktu_mulai.' - '.$data->waktu_akhir }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Link</div>
                  <div class="col-lg-9 col-md-8">{{ $data->link }}</div>
                </div>
              </div>
              <div class="tab-pane fade profile-edit pt-3" id="edit">
                <form action="{{ url($button->formEdit($title)) }}" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $data->id }}">
                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Kategori</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" aria-label="Default select example">
                        <option>--Pilih Kategori--</option>
                        <option {{ $data->kategori == 1 ? 'selected' : '' }} value="1">Online</option>
                        <option {{ $data->kategori == 0 ? 'selected' : '' }} value="0">Offline</option>
                      </select>
                      @error('kategori')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Judul Rapat</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="judul" class="form-control @error('judul') is-invalid @enderror">{{ $data->judul }}</textarea>
                      @error('judul')
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
                        <option {{ $data['id_departemen'] == '0' ? 'selected' : '' }} value="0">Semua / Umum</option>
                        @foreach($departemen as $dep)
                        <option {{ $dep['id'] == $data['id_departemen'] ? 'selected' : '' }} value="{{ $dep['id'] }}">{{ $dep->nama }}</option>
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
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Person in Charge</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="id_users" class="form-select @error('id_users') is-invalid @enderror" aria-label="Default select example">
                        <option>--Pilih Pegawai--</option>
                        @foreach($user as $usr)
                        <option {{ $usr['id'] == $data['id_users'] ? 'selected' : '' }} value="{{ $usr['id'] }}">{{ $usr['name'].' - '.$usr->jabatan->nama.' '.$usr->departemen->nama }}</option>
                        @endforeach
                      </select>
                      @error('id_users')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputDate" class="col-md-4 col-lg-3 col-form-label">Tanggal Rapat</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" value="{{ $data->tanggal }}">
                      @error('tanggal')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Waktu Mulai</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="waktu_mulai" type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" value="{{ $data->waktu_mulai }}">
                      @error('waktu_mulai')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Waktu Akhir</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="waktu_akhir" type="time" class="form-control @error('waktu_akhir') is-invalid @enderror" value="{{ $data->waktu_akhir }}">
                      @error('waktu_akhir')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Link</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="link" class="form-control @error('link') is-invalid @enderror">{{ $data->link }}</textarea>
                      @error('link')
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
                      Minutes of Meeting
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
  $('.show_confirm').click(function(event) {
    var form = $(this).closest("form");
    var name = $(this).data("name");
    event.preventDefault();
    swal({
        title: "Apakah yakin ingin menghapus data?",
        text: "Jika dihapus, data akan hilang selamanya.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
        }
      });
  });
</script>
<script>
  function getDataEdit(id) {
    $.ajax({
      url: "{{ url($button->formEtc('Soal').'/getsoal') }}",
      data: {
        "id": id
      },
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#soal-id').val(data.id);
        $('#soal-pertanyaan').val(data.pertanyaan);
        $('#soal-pilihan_a').val(data.pilihan_a);
        $('#soal-pilihan_b').val(data.pilihan_b);
        $('#soal-pilihan_c').val(data.pilihan_c);
        $('#soal-pilihan_d').val(data.pilihan_d);
        $('#soal-kunci_jawaban').val(data.kunci_jawaban).change();
      }
    })
  }
</script>
@endsection