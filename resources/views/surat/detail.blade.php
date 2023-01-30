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
          <div class="card-body profile-card  d-flex flex-column align-items-left">
            <h5 class="card-title">Statistik SE</h5>
            <!-- Progress Bars with labels-->
            @php
            $target = $cont->getTarget($data->ditujukan);
            $baca = $cont->getJmlStatus($data->id)['baca'];
            $tuntas = $cont->getJmlStatus($data->id)['tuntas'];
            $belum = $target - $baca;
            @endphp
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="{{ $target }}" aria-valuemin="0" aria-valuemax="{{ $target }}">{{ $target }} Anggota</div>
            </div>
            <p>Jumlah Target Staff</p>
            <div class="progress mt-3">
              <div class="progress-bar" role="progressbar" style="width: {{ number_format(($baca/$target)*100, 2, '.', ',') }}%" aria-valuenow="{{ $baca }}" aria-valuemin="0" aria-valuemax="{{ $target }}" title="{{ number_format(($baca/$target)*100, 2, '.', ',') }}%">{{ number_format(($baca/$target)*100, 2, '.', ',') }}%</div>
            </div>
            <p> SE Dilihat</p>
            <div class="progress mt-3">
              <div class="progress-bar" role="progressbar" style="width: {{ number_format(($tuntas/$target)*100, 2, '.', ',') }}%" aria-valuenow="{{ $tuntas }}" aria-valuemin="0" aria-valuemax="{{ $target }}" title="{{ number_format(($tuntas/$target)*100, 2, '.', ',') }}%">{{ number_format(($tuntas/$target)*100, 2, '.', ',') }}%</div>
            </div>
            <p>SE Tuntas</p>
            <div class="progress mt-3">
              <div class="progress-bar" role="progressbar" style="width: {{ number_format(($belum/$target)*100, 2, '.', ',') }}%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="{{ $target }}" title="{{ number_format(($belum/$target)*100, 2, '.', ',') }}%">{{ number_format(($belum/$target)*100, 2, '.', ',') }}%</div>
            </div>
            <p>Belum diketahui</p><!-- End Progress Bars with labels -->
            <br>
            <!-- Bordered Tabs Justified -->
            <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
              <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="bi bi-eye-fill"></i> &nbsp; SE Dilihat</button>
              </li>
              <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="bi bi-patch-check-fill"></i> &nbsp; SE Tuntas</button>
              </li>
            </ul>
            <div class="tab-content pt-2" id="borderedTabJustifiedContent">
              <div class="tab-pane fade active show" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
                <!-- Active Table -->
                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th scope="col">Nama</th>
                      <th scope="col">Jabatan</th>
                      <th scope="col">Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Burhan</td>
                      <td>IT Staff</td>
                      <td>2016-05-25</td>
                    </tr>
                    <tr>
                      <td>Khalis</td>
                      <td>Staff Marketing</td>
                      <td>2016-05-25</td>
                    </tr>
                    <tr>
                      <td>Ayu Dewi</td>
                      <td>Legal</td>
                      <td>2016-05-25</td>
                    </tr>
                    <tr>
                      <td>Susanti</td>
                      <td>HRD</td>
                      <td>2016-05-25</td>
                    </tr>
                    <tr>
                      <td>Budi Santoso</td>
                      <td>Akunting</td>
                      <td>2016-05-25</td>
                    </tr>
                  </tbody>
                </table>
                <!-- End Tables without borders -->
              </div>
              <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th scope="col">Nama</th>
                      <th scope="col">Jabatan</th>
                      <th scope="col">Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Burhan</td>
                      <td>IT Staff</td>
                      <td>2016-05-25</td>
                    </tr>
                    <tr>
                      <td>Susanti</td>
                      <td>HRD</td>
                      <td>2016-05-25</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div><!-- End Bordered Tabs Justified -->
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link {{ count($soal) > 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#overview">Detail</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#preview">Preview Surat</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit">Sunting</button>
              </li>
              <li class="nav-item">
                <button class="nav-link {{ count($soal) <= 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#soal">Soal</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#log">Log Pengerjaan</button>
              </li>
            </ul>
            <div class="tab-content pt-2">
              <div class="tab-pane fade {{ count($soal) > 0 ? 'show active' : '' }} profile-overview" id="overview">
                <h5 class="card-title">Detail Surat Edaran</h5>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Nomor Surat</div>
                  <div class="col-lg-9 col-md-8">{{ $data->nomor_surat }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Topik</div>
                  <div class="col-lg-9 col-md-8">{{ $data->topik->nama }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Keterangan Topic</div>
                  <div class="col-lg-9 col-md-8">{{ $data->keterangan_topik }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Dibuat Oleh</div>
                  <div class="col-lg-9 col-md-8">{{ $data->user->name }} - {{ $data->user->jabatan->nama.' '.$data->user->departemen->nama }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Tanggal Pembuatan</div>
                  <div class="col-lg-9 col-md-8">{{ date('d F Y', strtotime($data->tanggal)) }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Status SE</div>
                  <div class="col-lg-9 col-md-8">
                    @if($data->ditujukan == 0)
                    {{ $data->status_se == 0 ? 'Internal General' : 'External General' }}
                    @else
                    {{ $data->status_se == 0 ? 'Departemen' : 'External Pelanggan' }}
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Ditujukan Untuk</div>
                  <div class="col-lg-9 col-md-8">{{ $data->ditujukan == 0 ? 'Umum' : $data->departemen->nama }}</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Status Reminder</div>
                  <div class="col-lg-9 col-md-8">{!! $data->expired($data['tanggal_berakhir']) !!}</div>
                </div>
              </div>
              <div class="tab-pane fade" id="preview">
                <h5 class="card-title">Preview Surat</h5>
                <iframe src="{{ asset('upload/surat/'.date('Y', strtotime($data->tanggal)).'/'.date('m', strtotime($data->tanggal)).'/'.$data->file_surat) }}" width="100%" height="450px"></iframe>
              </div>
              <div class="tab-pane fade profile-edit pt-3" id="edit">
                <!-- Profile Edit Form -->

                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Lampiran</label>
                  <div class="col-md-8 col-lg-9">
                    <!-- <img src="https://cdn-icons-png.flaticon.com/512/4136/4136043.png" alt="Profile"> -->
                    <div class="pt-2">
                      <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#upload_surat">Ganti Surat</a>
                      <!-- <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a> -->
                    </div>
                  </div>
                </div>
                <form action="{{ url($button->formEdit($title)) }}" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $data->id }}">
                  <div class="row mb-3">
                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Nomor Surat</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="nomor_surat" type="text" class="form-control @error('nomor_surat') is-invalid @enderror" value="{{ $data['nomor_surat'] }}">
                      @error('nomor_surat')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Topic</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="id_topik" class="form-select @error('id_topik') is-invalid @enderror" aria-label="Default select example">
                        <option>--Pilih Topik--</option>
                        @foreach($topik as $top)
                        <option {{ $data['id_topik'] == $top['id'] ? 'selected' : '' }} value="{{ $top['id'] }}">{{ $top['nama'] }}</option>
                        @endforeach
                      </select>
                      @error('id_topik')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Keterangan Topic</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="keterangan_topik" class="form-control @error('keterangan_topik') is-invalid @enderror">{{ $data['keterangan_topik'] }}</textarea>
                      @error('keterangan_topik')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Dibuat Oleh</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" aria-label="Default select example">
                        <option>--Pilih Pegawai--</option>
                        @foreach($user as $usr)
                        <option {{ $usr['id'] == $data['id_user'] ? 'selected' : '' }} value="{{ $usr['id'] }}">{{ $usr['name'].' - '.$usr->jabatan->nama.' '.$usr->departemen->nama }}</option>
                        @endforeach
                      </select>
                      @error('id_user')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputDate" class="col-md-4 col-lg-3 col-form-label">Tanggal Pembuatan</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" value="{{ $data['tanggal'] }}">
                      @error('tanggal')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="StatusSE" class="col-md-4 col-lg-3 col-form-label">Status SE</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="status_se" id="gridRadios1" value="0" {{ $data->status_se == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="gridRadios1">
                          {{ $data->ditujukan == 0 ? 'Internal General' : 'Departemen'}}
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="status_se" id="gridRadios2" value="1" {{ $data->status_se == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="gridRadios2">
                          {{ $data->ditujukan == 0 ? 'Ekternal General' : 'Eksternal Pelanggan'}}
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Ditujukan Untuk</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="ditujukan" class="form-select @error('ditujukan') is-invalid @enderror" aria-label="Default select example">
                        <option>--Pilih Departemen/Divisi--</option>
                        <option {{ $data['ditujukan'] == '0' ? 'selected' : '' }} value="0">Semua / Umum</option>
                        @foreach($departemen as $dep)
                        <option {{ $dep['id'] == $data['ditujukan'] ? 'selected' : '' }} value="{{ $dep['id'] }}">{{ $dep->nama }}</option>
                        @endforeach
                      </select>
                      @error('ditujukan')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Status Reminder</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="reminder" class="form-select @error('reminder') is-invalid @enderror" aria-label="Default select example">
                        <option>--Pilih Jangka Waktu--</option>
                        <option {{ $data['reminder'] == 1 ? 'selected' : '' }} value="1">1 Bulan</option>
                        <option {{ $data['reminder'] == 3 ? 'selected' : '' }} value="3">3 Bulan</option>
                        <option {{ $data['reminder'] == 6 ? 'selected' : '' }} value="6">6 Bulan</option>
                        <option {{ $data['reminder'] == 12 ? 'selected' : '' }} value="12">12 Bulan</option>
                      </select>
                      @error('reminder')
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
              <div class="tab-pane {{ count($soal) <= 0 ? 'show active' : '' }} fade pt-3" id="soal">
                <div class="card">
                  <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah_soal">Tambah Pertanyaan</a>
                  @php
                  $i = 1;
                  @endphp
                  @foreach($soal as $sl)
                  <div class="card-header"><b>Pertanyaan {{ $i++ }}</b>
                    <form action="{{ url($button->formDelete('Soal'), ['id' => $sl->id, 'id_surat' => $data->id]) }}" method="POST" class="d-inline">
                      <button type="button" onclick="getDataEdit({{ $sl->id }})" class="btn btn-warning btn-sm btn-edit-soal" data-bs-toggle="modal" data-bs-target="#edit_soal">Ubah</button>

                      @csrf
                      @method('DELETE')

                      {!! $button->btnDelete($title) !!}
                    </form>
                  </div>
                  <div class="card-body">
                    <br>
                    <div class="col-sm-12">
                      <span>{{ $sl['pertanyaan'] }}</span>
                    </div>
                    <h5 class="card-title">Jawaban</h5>
                    <div class="row mb-3">
                      <div class="col-sm-1">
                        <span>A</span>
                      </div>
                      <div class="col-sm-10">
                        <span>{{ $sl->pilihan_ganda($sl['id'])[0] }}</span>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-1">
                        <span>B</span>
                      </div>
                      <div class="col-sm-10">
                        <span>{{ $sl->pilihan_ganda($sl['id'])[1] }}</span>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-1">
                        <span>C</span>
                      </div>
                      <div class="col-sm-10">
                        <span>{{ $sl->pilihan_ganda($sl['id'])[2] }}</span>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-1">
                        <span>D</span>
                      </div>
                      <div class="col-sm-10">
                        <span>{{ $sl->pilihan_ganda($sl['id'])[3] }}</span>
                      </div>
                    </div>
                    <div class="row mb-12">
                      <div class="col-sm-3">
                        <span><strong>Jawaban Benar</strong></span>
                      </div>
                      <div class="col-sm-4">
                        <span><strong>{{ $sl->kunci_jawaban }}</strong></span>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
                <!-- <div class="text-center">
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div> -->
              </div>
              <div class="tab-pane fade" id="log">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">Log Pengerjaan</h5>
                  </div>
                  <div class="card-body">
                    <table class="table table-borderless datatable">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Pegawai</th>
                          <th scope="col">Jabatan / Divisi</th>
                          <th scope="col">Nilai</th>
                          <th scope="col">Waktu Pengerjaan</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                        $i=1;
                        @endphp
                        @foreach($history_nilai as $log)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $log->users->name }}</td>
                          <td>{{ $log->users->jabatan->nama.' - '.$log->users->departemen->nama }}</td>
                          <td>{{ $log['nilai'].'/'.$log['nilai_max'] }}</td>
                          <td>{{ date('d-m-Y H:i', strtotime($log['created_at'])) }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
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
<div class="modal fade" id="upload_surat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ganti Surat</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url($button->formEtc($title)).'/ganti_surat' }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <input type="file" name="file_surat" class="form-control" required>
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
<div class="modal fade" id="tambah_soal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pertanyaan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url($button->formAdd('Soal')) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="col-sm-12">
            <input type="hidden" name="id_surat" value="{{ $data->id }}">
            <textarea class="form-control" name="pertanyaan" placeholder="Tulis pertanyaan" style="height: 100px"></textarea>
          </div>
          <h5 class="card-title">Jawaban</h5>
          <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">A</label>
            <div class="col-sm-10">
              <input type="text" name="pilihan[]" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">B</label>
            <div class="col-sm-10">
              <input type="text" name="pilihan[]" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">C</label>
            <div class="col-sm-10">
              <input type="text" name="pilihan[]" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">D</label>
            <div class="col-sm-10">
              <input type="text" name="pilihan[]" class="form-control" required>
            </div>
          </div>
          <div class="row mb-12">
            <label class="col-sm-3 col-form-label">Jawaban Benar</label>
            <div class="col-sm-4">
              <select class="form-select" name="kunci_jawaban" aria-label="Default select example">
                <option selected="">Pilih Jawaban</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
              </select>
            </div>
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
<div class="modal fade" id="edit_soal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Pertanyaan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url($button->formEdit('Soal')) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="col-sm-12">
            <input type="hidden" name="id_surat" value="{{ $data->id }}">
            <input type="hidden" name="id" id="soal-id" value="">
            <textarea class="form-control" id="soal-pertanyaan" name="pertanyaan" placeholder="Tulis pertanyaan" style="height: 100px"></textarea>
          </div>
          <h5 class="card-title">Jawaban</h5>
          <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">A</label>
            <div class="col-sm-10">
              <input type="text" name="pilihan[]" id="soal-pilihan_a" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">B</label>
            <div class="col-sm-10">
              <input type="text" name="pilihan[]" id="soal-pilihan_b" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">C</label>
            <div class="col-sm-10">
              <input type="text" name="pilihan[]" id="soal-pilihan_c" class="form-control" required>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">D</label>
            <div class="col-sm-10">
              <input type="text" name="pilihan[]" id="soal-pilihan_d" class="form-control" required>
            </div>
          </div>
          <div class="row mb-12">
            <label class="col-sm-3 col-form-label">Jawaban Benar</label>
            <div class="col-sm-4">
              <select class="form-select" name="kunci_jawaban" id="soal-kunci_jawaban" aria-label="Default select example">
                <option selected="">Pilih Jawaban</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
              </select>
            </div>
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