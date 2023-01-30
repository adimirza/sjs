<!DOCTYPE html>
<html lang="en">
<?php

use App\Lib\GetLibrary;
use App\Lib\GetProfilWeb;
$profil = new GetProfilWeb;
$lib = new GetLibrary;
?>
<head>
  @include('_partials._headerlib')
  @yield('headlib_req')
</head>

<body>

    @include('_partials.header')
    @include('_partials.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <main id="main" class="main">
      @yield('container')
    </main>
    @include('_partials.footer')

  @include('_partials._footerlib')
  @yield('footlib_req')
</body>
</html>