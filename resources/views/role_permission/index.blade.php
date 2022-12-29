@extends('_partials.main')
@section('container')
<section class="section">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ $title.' '.$role['nama'] }}</h3>
    </div>
    <!-- /.card-header -->
    <form action="{{ url($button->formAdd('Role Permission')) }}" method="POST">
      @csrf
      <input type="hidden" name="id_role" value="{{ $role['id'] }}">
      <div class="card-body">
        <div class="custom-control custom-checkbox">
          <input class="custom-control-input" type="checkbox" id="checkAll" value="1">
          <label for="checkAll" class="custom-control-label">Pilih Semua</label>
        </div>
        <br>
        <div class="row">
          @foreach($menu as $mn)
          <div class="col-md-2">
            <h5>{{ $mn['nama'] }}</h5>
            <div class="form-group">
              @foreach($menu_permission as $per)
              @if(($per['id_menu'] == $mn['id']) AND $per['is_active'])
              <?php 
              $role_per = App\Http\Controllers\RolePermission::getPermission($role['id'], $per['id']);
              ?>
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="{{ $per['id'] }}" name="id_permission[]" value="{{ $per['id'] }}" {{ $role_per ? 'checked' : '' }}>
                <label for="{{ $per['id'] }}" class="custom-control-label">{{ strtoupper($per['permission']) }}</label>
              </div>
              @endif
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</section>
<script>
  $("#checkAll").click(function() {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
</script>
@endsection