<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <style>
        /* Untuk nav-link yang aktif */
        .nav-link .active .icon-shape {
            background-color: white;
            color: white; /* Warna ikon menjadi hitam jika aktif */
        }

        /* Untuk ikon dalam nav-link yang aktif */
        .nav-link .active .icon-shape i {
            color: white; /* Warna ikon menjadi hitam jika aktif */
        }

        /* Untuk nav-link yang tidak aktif */
        .nav-link .icon-shape i {
            color: black; /* Warna ikon hitam jika tidak ada kelas active */
        }

        /* Jika ingin memberikan efek saat hover */
        .nav-link:hover .icon-shape {
            background-color: white; /* Background berubah saat hover */
        }

        .nav-link:hover .icon-shape i {
            color: gray; /* Warna ikon berubah saat hover */
        }
    </style>
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="<?=$backend_url;?>" target="_blank">
        <img src="<?=$assets_url;?>/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold"><?=$title;?></span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link <?= ($page == 'dashboard') ? 'active' : '' ?>" href="<?=$backend_url;?>">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-home"></i>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= ($page == 'sekolah') ? 'active' : '' ?>" href="<?=$backend_url;?>/pages/sekolah">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-school"></i>
                </div>
                <span class="nav-link-text ms-1">Data Sekolah</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= ($page == 'guru') ? 'active' : '' ?>" href="<?=$backend_url;?>/pages/guru">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-chalkboard-teacher"></i>
                </div>
                <span class="nav-link-text ms-1">Data Guru</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= ($page == 'siswa') ? 'active' : '' ?>" href="<?=$backend_url;?>/pages/siswa">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <span class="nav-link-text ms-1">Data Siswa</span>
            </a>
            </li>
            
            <li class="nav-item">
            <a class="nav-link <?= ($page == 'mata-pelajaran') ? 'active' : '' ?>" href="<?=$backend_url;?>/pages/sekolah">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-book"></i>
                </div>
                <span class="nav-link-text ms-1">Mata Pelajaran</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= ($page == 'absensi-siswa') ? 'active' : '' ?>" href="<?=$backend_url;?>/pages/absensi/siswa">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-clock"></i>
                </div>
                <span class="nav-link-text ms-1">Absensi Siswa</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?= ($page == 'absensi-guru') ? 'active' : '' ?>" href="<?=$backend_url;?>/pages/absensi/guru">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-clock"></i>
                </div>
                <span class="nav-link-text ms-1">Absensi Guru</span>
            </a>
            </li>

            <li class="nav-item">
            <a class="nav-link <?= ($page == 'devices') ? 'active' : '' ?>" href="<?=$backend_url;?>/pages/devices">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fa fa-server"></i>
                </div>
                <span class="nav-link-text ms-1">Data Perangkat</span>
            </a>
            </li>
            
        </ul>
        
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">