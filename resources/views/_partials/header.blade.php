  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ url('') }}" class="logo d-flex align-items-center">
        <img src="{{ url('upload/image/logo/'.$profil->getProfil()['logo']->logo) }}" alt="">
        <span class="d-none d-lg-block">{{ $profil->getProfil()['nama']->nama }}</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <nav class="header-nav ms-auto">

      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">{{ intval($lib->getNotifSurat()['blmDibaca'] + $lib->getNotifSurat()['blmTuntas'] + $lib->getNotifRapat()['blmKonfirmasi']) }}</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="width: 250px;">
            <li class="dropdown-header">
            {{ intval($lib->getNotifSurat()['blmDibaca'] + $lib->getNotifSurat()['blmTuntas'] + $lib->getNotifRapat()['blmKonfirmasi']) }} notifikasi baru.
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-danger"></i>
              <div>
                <h4>Belum Dibaca</h4>
                <p>{{ $lib->getNotifSurat()['blmDibaca'] }} surat belum dibaca.
                <a href="{{ url('kotak_masuk') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                </p>
              </div>
            </li>
            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Belum Tuntas</h4>
                <p>{{ $lib->getNotifSurat()['blmTuntas'] }} surat belum tuntas.
                <a href="{{ url('kotak_masuk') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                </p>
              </div>
            </li>
            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Rapat Belum Dikonfirmasi</h4>
                <p>{{ $lib->getNotifRapat()['blmKonfirmasi'] }} rapat belum dikonfirmasi.
                <a href="{{ url('rapat') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                </p>
              </div>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ url('upload/image/profil') }}{{auth()->user()->foto ? '/'.auth()->user()->foto : '/person-icon.png'}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->username }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ auth()->user()->name }}</h6>
              <span>{{ auth()->user()->jabatan->nama }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>