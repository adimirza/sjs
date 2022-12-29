@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section">
  <div class="col-12">
    <div class="card recent-sales overflow-auto">
      <div class="card-body">
        <h5 class="card-title">Kelengkapan </h5>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Nama</div>
          <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Jabatan</div>
          <div class="col-lg-9 col-md-8">{{ $user->jabatan->nama }}</div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-4 label ">Departemen/Divisi</div>
          <div class="col-lg-9 col-md-8">{{ $user->departemen->nama }}</div>
        </div>
        <br>
        <!-- Default Accordion -->
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
              <div class="accordion-body">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Atribut</th>
                        <th scope="col" width="15%"><center>Check Admin</center></th>
                        <th scope="col" width="15%"><center>Check User</center></th>
                        <th scope="col" width="30%">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <form action="{{ url($button->formAdd('Kelengkapan').'/'.$user->id) }}" method="POST">
                        @php
                        $i=1;
                        @endphp
                      @foreach($atribut as $atr)
                      @csrf
                      @php
                      $kel = $cont->getkelengkapan($user->id, $atr->id);
                      @endphp
                      <tr>
                        <td scope="col" class="align-middle"><input type="hidden" name="id_atribut[{{$i}}]" value="{{ $atr->id }}">{{ $atr->atribut }}</td>
                        <td scope="col" class="align-middle"><center><input {{ $kel['check_admin'] ? 'checked' : '' }} class="form-check-input" type="checkbox" value="1" name="check_admin[{{$i}}]"></center></td>
                        <td scope="col" class="align-middle"><center><input {{ $kel['check_user'] ? 'checked' : '' }} class="form-check-input" type="checkbox" value="1" name="check_user[{{$i}}]" disabled></center></td>
                        <td scope="col"><textarea class="form-control" name="keterangan[{{$i}}]" disabled> {{ $kel['keterangan'] }}</textarea></td>
                      </tr>
                      @php
                      $i++
                      @endphp
                      @endforeach
                      <tr>
                        <td colspan="4"><p class="text-end">
                          <input type="hidden" value="{{ $i-1 }}" name="jumlah">
                          <button type="submit" class="btn btn-primary">Submit</button></p>
                        </td>
                      </tr>
                      </form>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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