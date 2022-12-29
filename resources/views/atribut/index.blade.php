@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }} {!! $button->btnCreate('Atribut') !!}</h1>
</div>
<section class="section">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tabel {{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    <div class="table-responsive">
      <table id="example2" class="table table-borderless datatable">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th>Atribut</th>
            <th width="20%">Status</th>
            <th width="20%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php
            $i = 1;
          @endphp
          @foreach($data as $dt)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $dt['atribut'] }}</td>
            <td><span class="badge bg-{{ $dt['status'] ? 'success' : 'danger' }}">{{ $dt['status'] ? 'Aktif' : 'Tidak Aktif' }}</span></td>
            <td>
              
              <form action="{{ url($button->formDelete('Atribut'), ['id' => $dt->id]) }}" method="POST">
                    {!! $button->btnEdit('Atribut', $dt['id']) !!}

                    @csrf
                    @method('DELETE')
      
                    {!! $button->btnDelete('Atribut') !!}
                </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    </div>
  </div>
</section>
@endsection
@section('footlib_req')
<script src="{{ url('/assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
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