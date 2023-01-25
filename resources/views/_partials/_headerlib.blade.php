<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>{{ $profil->getProfil()['nama']->nama }} | {{ $title }}</title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="{{ url('upload/image/logo/'.$profil->getProfil()['logo']->logo) }}" rel="icon">
<link href="{{ url('upload/image/logo/'.$profil->getProfil()['logo']->logo) }}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="{{ asset('/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
<!-- <link href="{{ asset('/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
<link href="{{ asset('/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
<link href="{{ asset('/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
<link href="{{ asset('/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
<!-- <link href="{{ asset('/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/vendor/datatables/datatables.min.css')}}"/>
<!-- Template Main CSS File -->
<link href="{{ asset('/assets/css/style.css')}}" rel="stylesheet">

  <!-- Template Main JS File -->
  
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->