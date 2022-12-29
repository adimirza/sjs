@extends('_partials.main')
@section('container')
<section class="section">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{ $title.' '.$menu['nama'] }} <a href="{{ url($button->formEtc('Menu Permission').'/refresh', ['id' => $menu->id]) }}" class="btn btn-success btn-sm">Refresh Permission</a></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Permission</th>
            <th>Status</th>
          </tr>
        </thead>
          <tbody>
            @foreach($data as $dt)
            <tr>
              <td>{{ strtoupper($dt['permission']) }}</td>
              <td align="center">
                <form action="{{ url($button->formEtc('Menu Permission').'/status') }}" method="POST">
                @csrf
                  <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="hidden" name="id" value="{{ $dt['id'] }}">
                      <input type="checkbox" class="custom-control-input" id="{{ $dt['id'] }}" name="is_active" {{ $dt['is_active'] ? 'checked' : '' }} onclick="this.form.submit()">
                      <label class="custom-control-label" for="{{ $dt['id'] }}"></label>
                    </div>
                  </div>
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