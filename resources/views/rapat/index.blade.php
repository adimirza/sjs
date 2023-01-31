@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }} {!! $button->btnCreate($title) !!}</h1>
</div>
<section class="section">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tabel {{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table class="table table-borderless datatable">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Judul Rapat</th>
            <th scope="col">Divisi</th>
            <th scope="col">Waktu Mulai</th>
            <th scope="col">Waktu Akhir</th>
            <th scope="col">PIC</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php
          $i=1;
          @endphp
          @foreach($data as $dt)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $dt->judul }}</td>
            <td>{{ $dt->id_departemen ? $dt->departemen->nama : 'Umum' }}</td>
            <td>{{ $dt->tanggal .'|'. $dt->waktu_mulai }}</td>
            <td>{{ $dt->tanggal .'|'. $dt->waktu_akhir }}</td>
            <td>{{ $dt->user->name }}</td>
            <td>

              <form action="{{ url($button->formDelete($title), ['id' => $dt->id]) }}" method="POST">
                <a href="{{ url($button->formEtc($title).'/detail/'.$dt->id) }}" class="btn btn-info btn-sm"><i class="bi bi-info-circle"></i></a>
                @if((auth()->user()->jabatan->role->nama == 'Member') AND (!$cont->lib->getKonfirmasiRapat($dt->id)))
                <a href="#" data-st="input" data-id="{{ $dt->id }}" data-bs-toggle="modal" data-bs-target="#konfirmasi" class="btn btn-primary btn-sm btn-konfirmasi"><i class="bi bi-symmetry-horizontal"></i></a>
                @elseif((auth()->user()->jabatan->role->nama == 'Member') AND ($cont->lib->getKonfirmasiRapat($dt->id)))
                  <a href="#" data-st="edit" data-id="{{ $cont->lib->getKonfirmasiRapat($dt->id)['id'] }}" 
                              data-konfirmasi="{{ $cont->lib->getKonfirmasiRapat($dt->id)['konfirmasi'] }}" 
                              data-keterangan="{{ $cont->lib->getKonfirmasiRapat($dt->id)['keterangan'] }}" 
                              data-bs-toggle="modal" data-bs-target="#konfirmasi" 
                              class="btn btn-{{ $cont->lib->getKonfirmasiRapat($dt->id)['konfirmasi'] == 1 ? 'success' : 'danger' }} btn-sm btn-konfirmasi">
                              <i class="bi bi-symmetry-horizontal"></i></a>
                @endif
                @csrf
                @method('DELETE')

                {!! $button->btnDelete($title) !!}
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

<div class="modal fade" id="konfirmasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url($button->formEtc('Rapat').'/konfirmasi') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row mb-3">
            <input type="hidden" name="id" id="konfirmasi-id_rapat">
            <input type="hidden" name="st" id="konfirmasi-st">
            <label for="StatusSE" class="col-md-4 col-lg-3 col-form-label">Konfirmasi Kehadiran</label>
            <div class="col-md-8 col-lg-9">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="konfirmasi" id="konfirmasi1" value="1" required>
                <label class="form-check-label" for="konfirmasi1">
                  Ya
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="konfirmasi" id="konfirmasi2" value="0" required>
                <label class="form-check-label" for="konfirmasi2">
                  Tidak
                </label>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputDate" class="col-md-4 col-lg-3 col-form-label">Keterangan</label>
            <div class="col-md-8 col-lg-9">
              <textarea name="keterangan" class="form-control" id="konfirmasi-keterangan"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info">Simpan</button>
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
    $(".btn-konfirmasi").click(function() {
      var id = $(this).data('id');
      var st = $(this).data('st');
      $('#konfirmasi-id_rapat').val(id);
      $('#konfirmasi-st').val(st);
      if(st == 'edit'){
        var ket = $(this).data('keterangan');
        $('#konfirmasi-keterangan').val(ket);
        if($(this).data('konfirmasi') == 1){
          $("#konfirmasi1").prop("checked", true);
        }else{
          $("#konfirmasi2").prop("checked", true);
        }
        
      }
    });
  });
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