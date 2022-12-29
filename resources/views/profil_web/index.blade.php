@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section">
  <div class="card">
    <!-- /.card-header -->
    <div class="card-body">
      <div class="card-header">
        
      </div>
      <div class="accordion" id="accordionExample">
        @foreach($data as $dt)
        @if($dt != 'created_by' AND $dt != 'updated_by' AND $dt != 'id')
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{$dt}}" aria-expanded="false" aria-controls="{{$dt}}">
              {{ strtoupper($dt) }}
            </button>
          </h2>
          <div id="{{$dt}}" class="accordion-collapse collapse" aria-labelledby="{{$dt}}" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="card-body">
                @if($dt != 'logo')
                {{ $getProfil->getProfil()[$dt]->$dt }}
                @else
                <img src="{{ url('upload/image/logo/'.$getProfil->getProfil()[$dt]->$dt) }}" style="height: 100px; width: 150px;">
                @endif
              </div>
              <div class="card-footer">
                @if($button->btnEdit('Profil Web'))
                <button data-bs-toggle="modal" data-field="{{ $dt }}" data-id="{{ $getProfil->getProfil()['id']->id }}" data-value="{{ $getProfil->getProfil()[$dt]->$dt }}" data-bs-target="{{ $dt == 'logo' ? '#modal-logo' : '#modal-ubah'}}" class="btn btn-warning btn-sm btn-ubah">Ubah</button>
                @endif
              </div>
            </div>

          </div>
        </div>
        @endif
        @endforeach
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modal-ubah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ubah <span id="nama-field"></span></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url($button->formEdit('Profil Web')) }}" method="post">
        @csrf
        <div class="modal-body">
          <textarea class="form-control" name="value" id="ubah-value" required></textarea>
          <input type="hidden" name="id" id="ubah-id">
          <input type="hidden" name="field" id="ubah-field">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-logo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ubah Logo</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url($button->formEdit('Profil Web')) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <!-- <textarea class="form-control" name="value" id="ubah-value"></textarea> -->
          <input type="file" name="value" class="form-control" required>
          <input type="hidden" name="id" value="{{ $getProfil->getProfil()['id']->id }}">
          <input type="hidden" name="field" value="logo">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('footlib_req')
<script src="{{ url('/assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".btn-ubah").click(function() {
      console.log('ubah');
      var id = $(this).data('id');
      var field = $(this).data('field');
      var value = $(this).data('value');
      console.log($(this).data('value'));
      $('#ubah-id').val(id);
      $('#ubah-field').val(field);
      $('#ubah-value').val(value);
      $('#nama-field').html(field);
    });
  });
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