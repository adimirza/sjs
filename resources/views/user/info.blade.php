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
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="{{ url('upload/image/profil') }}{{$data->foto ? '/'.$data->foto : '/person-icon.png'}}" alt="Profile" class="rounded-circle">
            <h2>{{ $data->name }}</h2>
            <h3>{{ $data->jabatan->nama }} - {{ $data->departemen->nama }}</h3>
            <span class="badge bg-{{ $data->status ? 'success' : 'danger' }}"><i class="bi bi-{{ $data->status ? 'check-circle' : 'x-circle' }} me-1"></i> {{ $data->status ? 'Aktif' : 'Non-Aktif' }}</span>
          </div>
        </div>

        <div class="card">
          <div class="card-body profile-card  d-flex flex-column align-items-left">
            <h5 class="card-title">Statistik Anggota</h5>
            <p>Statistik Surat Edaran yang sudah tuntas dipahami anggota</p>
            <!-- Progress Bars with labels-->

            <div class="progress">

              <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">20/40</div>
            </div>
            <p>SE Umum</p>

            <div class="progress mt-3">
              <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">4/10</div>
            </div>
            <p> SE Divisi</p>
          </div>
        </div>
      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Profil</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profil</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Log Histori</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Password</button>
              </li>
            </ul>
            <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">Profil Detail</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">ID</div>
                  <div class="col-lg-9 col-md-8">{{ $data->id_pegawai }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                  <div class="col-lg-9 col-md-8">{{ $data->name }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                  <div class="col-lg-9 col-md-8">{{ $data->jenis_kelamin ? 'Laki-laki' : 'Perempuan' }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Tempat Lahir</div>
                  <div class="col-lg-9 col-md-8">{{ $data->tempat_lahir }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Tanggal Lahir</div>
                  <div class="col-lg-9 col-md-8">{{ date('d F Y', strtotime($data->tanggal_lahir)) }} <span>({{ $data->umur() }}thn)</span></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Nomor Handphone</div>
                  <div class="col-lg-9 col-md-8">{{ $data->no_hp }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{ $data->email }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Alamat</div>
                  <div class="col-lg-9 col-md-8">{{ $data->alamat }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Tanggal Masuk</div>
                  <div class="col-lg-9 col-md-8">{{ date('d F Y', strtotime($data->tanggal_masuk)) }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Tanggal Berakhir</div>
                  <div class="col-lg-9 col-md-8">{{ date('d F Y', strtotime($data->tanggal_berakhir)) }}</div>
                </div>
              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <!-- Profile Edit Form -->
                <form action="{{ url($button->formEdit('Pegawai')) }}" method="POST">
                  @csrf
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
                    <div class="col-md-8 col-lg-9">
                      <img src="{{ url('upload/image/profil') }}{{$data->foto ? '/'.$data->foto : '/person-icon.png'}}" alt="Profile">
                      <div class="pt-2">
                        <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" data-bs-toggle="modal" data-bs-target="#upload_foto"><i class="bi bi-upload"></i></a>
                        <a href="{{ url($button->formEtc('Pegawai')).'/hapus_foto/'.$data->id }}" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $data->name }}">
                      @error('name')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="company" class="col-md-4 col-lg-3 col-form-label">ID</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="id_pegawai" type="text" class="form-control @error('id_pegawai') is-invalid @enderror" value="{{ $data->id_pegawai }}">
                      <input name="id" type="hidden" value="{{ $data->id }}">
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
                        <option {{ $data->jenis_kelamin == '1' ? 'selected' : '' }} value="1">Laki-laki</option>
                        <option {{ $data->jenis_kelamin == '0' ? 'selected' : '' }} value="0">Perempuan</option>
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
                      <input name="tempat_lahir" type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ $data->tempat_lahir }}">
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
                      <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ $data->tanggal_lahir }}">
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
                        <option {{ $dep['id'] == $data->id_departemen ? 'selected' : '' }} value="{{ $dep['id'] }}">{{ $dep['nama'] }}</option>
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
                        <option {{ $jab['id'] == $data->id_jabatan ? 'selected' : '' }} value="{{ $jab['id'] }}">{{ $jab['nama'] }}</option>
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
                      <input name="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" value="{{ $data->no_hp }}">
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
                      <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $data->email }}">
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
                      <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" style="height: 100px">{{ $data->alamat }}</textarea>
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
                        <option {{ $data->status == '1' ? 'selected' : '' }} value="1">Aktif</option>
                        <option {{ $data->status == '0' ? 'selected' : '' }} value="0">Non-Aktif</option>
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
                      <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" name="tanggal_masuk" value="{{ $data->tanggal_masuk }}">
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
                      <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror" name="tanggal_berakhir" value="{{ $data->tanggal_berakhir }}">
                      @error('tanggal_berakhir')
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
              <div class="tab-pane fade pt-3" id="profile-settings">
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Tanggal</th>
                      <th scope="col">Aktivitas</th>
                      <th scope="col">Hasil</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>2016-05-25</td>
                      <td>Buka SE Perekurtan Karyawan Internal</td>
                      <td><span class="badge rounded-pill bg-success">Sukses</span></td>
                    </tr>
                    <tr>
                      <td>2016-05-25</td>
                      <td>Mengerjakan Soal SE Perektrutan Karyawan Internal</td>
                      <td><span class="badge rounded-pill bg-warning text-dark">Belum Lulus</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form method="POST" action="{{ url($button->formEtc('Pegawai').'/reset') }}">
                  @csrf
                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password Kini</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror">
                      <input name="id" type="hidden" value="{{ $data->id }}">
                      @error('old_password')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control @error('password') is-invalid @enderror">
                      @error('password')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Ulangi Password Baru</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror">
                      @error('password_confirmation')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                  </div>
                </form><!-- End Change Password Form -->
              </div>
            </div><!-- End Bordered Tabs -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- <div class="card">
    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    </div>
  </div> -->
</section>
<div class="modal fade" id="upload_foto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Foto Profil</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url($button->formEtc('Pegawai')).'/ganti_foto' }}" method="POST" enctype="multipart/form-data">
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