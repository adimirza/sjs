@extends('_partials.main')
@section('headlib_req')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ url('/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ url('/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('container')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ $title }}</h1>
      </div>
    </div>
  </div>
  <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tabel</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Body</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $dt)
              <tr>
                <td>{{ $dt['name'] }}</td>
                <td>{{ $dt['email'] }}</td>
                <td>{{ $dt['body'] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
</section>
@endsection
@section('footlib_req')
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
<!-- DataTables  & Plugins -->
<script src="{{ url('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ url('/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ url('/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ url('/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ url('/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ url('/assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ url('/assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ url('/assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ url('/assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ url('/assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ url('/assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
@endsection