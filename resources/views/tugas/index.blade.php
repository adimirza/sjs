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
      @if(auth()->user()->jabatan->role->nama != 'Member')
      <form action="{{ url('kunjungan') }}" method="GET">
        <div class="row">
          <div class="col-3">
            <select name="id_departemen" id="id_departemen" class="form-select" aria-label="Default select example">
              <option value="">--Pilih Divisi/Departemen--</option>
              @foreach ($departemen as $dep)
              <option {{ $dep['id'] == $id_departemen ? 'selected' : '' }} value="{{ $dep['id'] }}">{{ $dep['nama'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-2">
            <select name="id_pegawai" id="id_pegawai" class="form-select" aria-label="Default select example">
              <option value="">--Pilih Pegawai--</option>
            </select>
          </div>
          <div class="col-2">
            <input type="date" class="form-select" name="tgl_awal" value="{{ $tgl_awal }}">
          </div>
          <div class="col-1">
            <span class="align-bottom">sampai</span>
          </div>
          <div class="col-2">
            <input type="date" class="form-select" name="tgl_akhir" value="{{ $tgl_akhir }}">
          </div>
          <div class="col-2">
            <button type="sumbit" class="btn btn-primary">Filter</button>
          </div>
        </div>
      </form>
      @endif
      <table class="table table-borderless datatable">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Nama Staff</th>
            <th scope="col">Divisi</th>
            <th scope="col">Nama Customer</th>
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
            <td>{{ $dt->nama_customer }}</td>
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
<script>
  $(document).ready(function() {
    getuser('{{ $id_departemen }}', '{{ $id_pegawai }}');
    $("#id_departemen").change(function() {
      var id = $('#id_departemen').val();
      var iduser = '';
      getuser(id, iduser);
    });
  });

  function getuser(iddepartemen, iduser) {
    $.ajax({
      url: "{{ url($button->formEtc('Kunjungan').'/getdata') }}",
      data: {
        "id": iddepartemen,
      },
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        var html = '<option value="">--Pilih Pegawai--</option>';
        var i;
        for (i = 0; i < data.length; i++) {
          if (iduser == data[i].id) {
            html += '<option selected value=' + data[i].id + '>' + data[i].name + '</option>';
          } else {
            html += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
          }
        }
        $('#id_pegawai').html(html);
      }
    })
  }
</script>
@endsection