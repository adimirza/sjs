@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section">
  <div class="col-12">
    <div class="card recent-sales overflow-auto">
      <div class="card-body">
        <h5 class="card-title">Histori Pelanggaran / Teguran </h5>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Nama</div>
          <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Jabatan</div>
          <div class="col-lg-9 col-md-8">{{ $user->jabatan->nama }}</div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Departemen/Divisi</div>
          <div class="col-lg-9 col-md-8">{{ $user->departemen->nama }}</div>
        </div>
        <br>
        <div class="row">
          <!-- Customers Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">Pelanggaran </h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-x-circle-fill"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $user->jumlah_teguran($user->id)['pelanggaran'] }}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Customers Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">Teguran </h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-exclamation-circle-fill"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $user->jumlah_teguran($user->id)['teguran'] }}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Customers Card -->
        </div>
        <center>
          <a href="{{ url($button->formEtc('Teguran').'/add/'.$user->id) }}" class="btn btn-primary"><i class="bi bi-plus me-1"></i> Tambah</a>
        </center>
        <br>
        <br>
        <!-- Default Accordion -->
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" fdprocessedid="r5qcqs">
                Riwayat
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
              <div class="accordion-body">
                <div class="table-responsive">
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Pelanggaran/Teguran</th>
                        <th scope="col">Kategori</th>
                        <th scope="col" width="20%">Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $dt)
                      <tr>
                        <th scope="col">{{ date('d-m-Y', strtotime($dt->tanggal)) }}</th>
                        <th scope="col">{{ $dt->keterangan }}</th>
                        <th scope="col">{!! $dt->ket_kategori($dt->kategori) !!}</th>
                        <th scope="col" width="25%">
                          <form action="{{ url($button->formDelete('Teguran'), ['id' => $dt->id, 'id_users' => $user->id]) }}" method="POST">
                            {!! $button->btnEdit('Teguran', $dt['id']) !!}

                            @csrf
                            @method('DELETE')

                            {!! $button->btnDelete('Teguran') !!}
                            <a href="{{ url('upload/surat/teguran/'.$dt->file_surat) }}" target="_blank" class="btn btn-primary btn-sm">Lihat Surat</a>
                          </form>
                        </th>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
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
@endsection