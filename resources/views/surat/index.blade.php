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
            <th scope="col">Topik</th>
            <th scope="col">Keterangan Topik</th>
            <th scope="col">Nomor Surat</th>
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
            <td>{{ $dt->topik->nama ? $dt->topik->nama : '' }}</td>
            <td>{{ $dt['keterangan_topik'] }}</td>
            <td>{{ $dt['nomor_surat'] }}</td>
            <td>{!! $dt->expired($dt['tanggal_berakhir']) !!}</td>
            <td>

              <form action="{{ url($button->formDelete($title), ['id' => $dt->id]) }}" method="POST">
                <a href="{{ url($button->formEtc($title).'/detail/'.$dt->id) }}" class="btn btn-info btn-sm"><i class="bi bi-info-circle"></i></a>
                <!-- <a href="{{ url($button->formEtc($title).'/info/'.$dt->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-collection"></i></a> -->

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