<aside id="sidebar" class="sidebar">
    <!-- <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="index.html">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-heading">Kelola Surat Edaran</li>
        <li class="nav-item ">
            <a class="nav-link collapsed" data-bs-target="#Kelengkapan-nav" data-bs-toggle="collapse" href="#">
                <i class="ri-exchange-funds-fill"></i><span>Surat Edaran</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="Kelengkapan-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="seumum.html">
                        <i class="bi bi-circle"></i><span>Surat Edaran Umum</span>
                    </a>
                </li>
                <li>
                    <a href="sekhusus.html">
                        <i class="bi bi-circle"></i><span>Surat Edaran Khusus</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="ri-exchange-funds-fill"></i><span>Data Staff</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="profilstaff.html">
                        <i class="bi bi-circle"></i><span>Profil</span>
                    </a>
                </li>
                <li>
                    <a href="Jabatan.html">
                        <i class="bi bi-circle"></i><span>Jabatan</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-card-checklist"></i>
                <span>Departemen/Divisi</span>
            </a>
        </li>
        <br><br>
        <li class="nav-heading">Pengaturan Pengguna</li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#pengguna-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people-fill"></i><span>Kelola Pengguna</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="pengguna-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="pengguna.html">
                        <i class="bi bi-circle"></i><span>Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>Role</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul> -->
    <?php
    use App\Lib\GetMenu;
    $menu = new GetMenu;
    echo $menu->getAllMenus($title);
    ?>
</aside><!-- End Sidebar-->