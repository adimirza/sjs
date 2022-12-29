@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }} {!! $button->btnCreate('Menu') !!} {!! $button->btnRead('Menu Heading') !!}</h1>
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
            <th>URL</th>
            <th>URI</th>
            <th>Icon</th>
            <th>Urutan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $dt)
          <tr>
            <td>{{ $dt['nama'] }}</td>
            <td>{{ $dt['url'] }}</td>
            <td>{{ $dt['uri'] }}</td>
            <td>{{ $dt['icon'] }}</td>
            <td>{{ $dt['urutan'] }}</td>
            <td align="center">
              <form action="{{ url($button->formEtc('Menu').'/status') }}" method="POST">
                @csrf
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="hidden" name="id" value="{{ $dt['id'] }}">
                    <input type="checkbox" class="custom-control-input" id="{{ $dt['id'] }}" name="status" {{ $dt['status'] ? 'checked' : '' }} onclick="this.form.submit()">
                    <label class="custom-control-label" for="{{ $dt['id'] }}"></label>
                  </div>
                </div>
              </form>
            </td>
            <td>

              <form action="{{ url($button->formDelete('Menu'), ['id' => $dt['id']]) }}" method="POST">
                {!! $button->btnEdit('Menu', $dt['id']) !!}

                @csrf
                @method('DELETE')

                {!! $button->btnDelete('Menu') !!}
                {!! $button->btnRead('Menu Permission', $dt['id']) !!}
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