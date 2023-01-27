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
            <th scope="col">Nama Staff</th>
            <th scope="col">Divisi</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Waktu</th>
            <th scope="col">Status</th>
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
            <td>{{ $dt->user->name }}</td>
            <td>{{ $dt->user->departemen->nama }}</td>
            <td>{{ $dt->deskripsi }}</td>
            <td>{{ date('d F Y H:i', strtotime($dt->tanggal)) }}</td>
            <td>
              @if($dt->status == 0)
                <span class="badge rounded-pill bg-warning">Belum Dikerjakan</span>
              @elseif($dt->status == 1)
                <span class="badge rounded-pill bg-info">Sedang Dikerjakan</span>
              @else
                <span class="badge rounded-pill bg-success">Sudah Dikerjakan</span>
              @endif
            </td>
            <td>

              <form action="{{ url($button->formDelete($title), ['id' => $dt->id]) }}" method="POST">
                <a href="{{ url($button->formEtc($title).'/detail/'.$dt->id) }}" class="btn btn-info btn-sm"><i class="bi bi-info-circle"></i></a>

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