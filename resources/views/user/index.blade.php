@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }} {!! $button->btnCreate('Pegawai') !!}</h1>
</div>
<section class="section">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tabel {{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <form action="{{ url($button->formEtc('Pegawai')) }}" method="GET" class="d-inline">
        <div class="row">
          <div class="col-4">
            <select class="form-select" id="fil-idDepartement/Divisi" name="id_departemen" aria-label="Default select example" required="">
              <option value="">Pilih Departement/Divisi</option>
              <option {{ $id_departemen == 99 ? 'selected' : '' }} value="99">Semua Departemen/Divisi</option>
              @foreach($departemen as $dep)
              <option {{ $id_departemen == $dep['id'] ? 'selected' : '' }} value="{{ $dep['id'] }}">{{ $dep['nama'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-1">
            <button type="submit" class="btn btn-primary">Pilih</button>
          </div>
          <div class="col-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#import">Import Pegawai</button>
          </div>
        </div>
      </form>
      <br>
      <table class="table table-borderless" id="data_user">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">ID</th>
            <th scope="col">Nama</th>
            <th scope="col">Username</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Departement/Divisi</th>
            <th scope="col"></th>
            <th scope="col">Opsi</th>
          </tr>
        </thead>
        <tbody>
          @php
          $i=1;
          @endphp
          @foreach($data as $dt)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $dt['id_pegawai'] }}</td>
            <td>{{ $dt['name'] }}</td>
            <td>{{ $dt['username'] }}</td>
            <td>{{ $dt->jabatan->nama }}</td>
            <td>{{ $dt->departemen->nama }}</td>
            <td><a href="{{ url($button->formEtc('Kelengkapan').'/'.$dt->id) }}" class="btn btn-primary btn-sm">Kelengkapan</a></td>
            <td>

              <form action="{{ url($button->formDelete('Pegawai'), ['id' => $dt->id]) }}" method="POST">
                <a href="{{ url($button->formEtc('Pegawai').'/info/'.$dt->id) }}" class="btn btn-info btn-sm"><i class="bi bi-info-circle"></i></a>
                <a href="{{ url($button->formEtc('Teguran').'/'.$dt->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-collection"></i></a>

                @csrf
                @method('DELETE')

                {!! $button->btnDelete('Pegawai') !!}
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
<div class="modal fade" id="import" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url($button->formEtc('Pegawai').'/import_excel') }}" enctype="multipart/form-data">
      <div class="modal-body">
        @csrf
        <input type="file" name="file" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Import</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('footlib_req')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
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

  $(document).ready(function() {
    $('#data_user').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
      ]
    });
  });
</script>
@endsection