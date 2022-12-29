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
      <div class="col-xl-12">
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
                <button class="nav-link {{ count($soal) <= 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#soal">Soal</button>
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
                  <div class="col-lg-9 col-md-8">{{ $data->status_se == 0 ? 'Internal' : 'External' }}</div>
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

              <div class="tab-pane {{ count($soal) <= 0 ? 'show active' : '' }} fade pt-3" id="soal">
                <form method="POST" action="{{ url('kotak_masuk/jawab_soal') }}">
                  @csrf
                  @php
                  $i = 1;
                  @endphp
                  @foreach($soal as $sl)
                  @php
                  $jawaban = $cont->getJawaban($sl->id)['jawaban'];
                  $is_benar = $cont->getJawaban($sl->id)['is_benar'];
                  @endphp
                  <div class="card {{ !$is_benar ? 'text-white bg-danger' : ''}}">
                    <div class="card-header {{ !$is_benar ? 'text-white bg-danger' : ''}}">Pertanyaan {{ $i }}</div>
                    <div class="card-body">
                      <span>{{ $sl['pertanyaan'] }}</span>
                      <input type="hidden" name="id_soal[{{$i}}]" value="{{ $sl['id'] }}">
                      <h5 class="card-title">Jawaban</h5>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" {{ $jawaban == 'A' ? 'checked' : '' }} name="jawaban[{{$i}}]" id="jawaban_a{{$i}}" value="A" required>
                        <label class="form-check-label" for="jawaban_a{{$i}}">
                          A. {{ $sl->pilihan_ganda($sl['id'])[0] }}
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" {{ $jawaban == 'B' ? 'checked' : '' }} name="jawaban[{{$i}}]" id="jawaban_b{{$i}}" value="B" required>
                        <label class="form-check-label" for="jawaban_b{{$i}}">
                          B. {{ $sl->pilihan_ganda($sl['id'])[1] }}
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" {{ $jawaban == 'C' ? 'checked' : '' }} name="jawaban[{{$i}}]" id="jawaban_c{{$i}}" value="C" required>
                        <label class="form-check-label" for="jawaban_c{{$i}}">
                          C. {{ $sl->pilihan_ganda($sl['id'])[2] }}
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" {{ $jawaban == 'D' ? 'checked' : '' }} name="jawaban[{{$i}}]" id="jawaban_d{{$i}}" value="D" required>
                        <label class="form-check-label" for="jawaban_d{{$i}}">
                          D. {{ $sl->pilihan_ganda($sl['id'])[3] }}
                        </label>
                      </div>
                    </div>
                  </div>
                  @php
                  $i++;
                  @endphp
                  @endforeach
                  <div class="card">
                    <div class="card-footer">
                      <input type="hidden" name="jumlah" value="{{ $i-1 }}">
                      <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                  </div>

                </form>
                <!-- <div class="text-center">
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div> -->
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