<?php
use App\Lib\GetProfilWeb;
$profil = new GetProfilWeb;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $profil->getProfil()['nama']->nama }} | Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ ('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ ('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ ('assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page dark-mode">
  <div class="login-box">
    <div class="login-logo">
      <!-- <a href=""><b>Admin</b>LTE</a> -->
      <img src="{{ url('upload/image/logo/'.$profil->getProfil()['logo']->logo) }}" alt="{{ $profil->getProfil()['nama']->nama }} Logo" style="opacity: .8"><br>
      <span class="brand-text font-weight-light">{{ $profil->getProfil()['nama']->nama }}</span>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
      <form action="{{ url('/register/store') }}" method="post">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama</label>
          <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">
          @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
      </div>
    </div>
  </div>

  <script src="{{ ('assets/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ ('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ ('assets/dist/js/adminlte.min.js') }}"></script>
</body>

</html>