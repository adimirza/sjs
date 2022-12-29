@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }} {!! $button->btnCreate('Menu Heading') !!}</h1>
</div>
<section class="section">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tabel {{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Nama</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $dt)
          <tr>
            <td>{{ $dt['nama_heading'] }}</td>
            <td width="20%">

              <form action="{{ url($button->formDelete('Menu Heading'), ['id' => $dt['id']]) }}" method="POST">
                {!! $button->btnEdit('Menu Heading', $dt['id']) !!}

                @csrf
                @method('DELETE')

                {!! $button->btnDelete('Menu Heading') !!}
                <!-- <a href="{{ url('/menu_permission', ['id' => $dt['id']]) }}" class="btn btn-info btn-sm">Permission</a> -->
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