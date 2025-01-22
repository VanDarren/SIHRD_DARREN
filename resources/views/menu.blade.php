<body class="vertical light">
  <div class="wrapper">
    <nav class="topnav navbar navbar-light">
      <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
      </button>
      <form class="form-inline mr-auto searchform text-muted">
        <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Cari layanan..." aria-label="Search">
      </form>
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
            <i class="fe fe-sun fe-16"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-shortcut">
            <span class="fe fe-grid fe-16"></span>
          </a>
        </li>
        <li class="nav-item nav-notif">
          <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
            <span class="fe fe-bell fe-16"></span>
            <span class="dot dot-md bg-success"></span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="avatar avatar-sm mt-2">
              <img src="{{asset('img/user.png') }}" alt="..." class="avatar-img rounded-circle">
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="">Profile</a>
            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
          </div>
        </li>
      </ul>
    </nav>
    <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
  <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
    <i class="fe fe-x"><span class="sr-only"></span></i>
  </a>
  <nav class="vertnav navbar navbar-light">
    <!-- Logo -->
    <div class="w-100 mb-4 d-flex">
      <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/' . $darren2->iconmenu) }}" alt="IconMenu" class="logo-dashboard img-fit-menu">
      </a>
    </div>

    <!-- Main Menu -->
    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li class="nav-item">
        <a href="{{ route('dashboard') }}" aria-expanded="false" class="nav-link">
          <i class="fe fe-home fe-16"></i>
          <span class="ml-3 item-text">Dashboard</span>
        </a>
      </li>
    </ul>

    <!-- Conditional Menus -->
    @php
      $id_level = session('id_level');
    @endphp

    @if($id_level == 1)
      <!-- Menu for id_level 1 -->
      <p class="text-muted nav-heading mt-4 mb-1"><span>Data</span></p>
      <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item">
          <a href="" class="nav-link">
            <i class="fe fe-users fe-16"></i>
            <span class="ml-3 item-text">Karyawan</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link">
            <i class="fe fe-dollar-sign fe-16"></i>
            <span class="ml-3 item-text">Gaji</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('lowongan') }}" class="nav-link">
            <i class="fe fe-briefcase fe-16"></i>
            <span class="ml-3 item-text">Lowongan</span>
          </a>
        </li>
      </ul>
      <p class="text-muted nav-heading mt-4 mb-1"><span>Lamaran</span></p>
      <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item">
          <a href="" class="nav-link">
            <i class="fe fe-file-text fe-16"></i>
            <span class="ml-3 item-text">Lamaran</span>
          </a>
        </li>
      </ul>
      <p class="text-muted nav-heading mt-4 mb-1"><span>Pengaturan</span></p>
      <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item">
          <a href="" aria-expanded="false" class="nav-link">
            <i class="fe fe-settings fe-16"></i>
            <span class="ml-3 item-text">Setting</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" aria-expanded="false" class="nav-link">
            <i class="fe fe-user fe-16"></i>
            <span class="ml-3 item-text">User</span>
          </a>
        </li>
      </ul>
    @elseif($id_level == 2)
      <!-- Menu for id_level 2 -->
      <p class="text-muted nav-heading mt-4 mb-1"><span>Data</span></p>
      <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item">
          <a href="" class="nav-link">
            <i class="fe fe-dollar-sign fe-16"></i>
            <span class="ml-3 item-text">Gaji</span>
          </a>
        </li>
      </ul>
    @elseif($id_level == 3)
      <!-- Menu for id_level 3 -->
      <p class="text-muted nav-heading mt-4 mb-1"><span>Data</span></p>
      <ul class="navbar-nav flex-fill w-100 mb-2">
        <li class="nav-item">
          <a href="{{ route('lowongan') }}" class="nav-link">
            <i class="fe fe-briefcase fe-16"></i>
            <span class="ml-3 item-text">Lowongan</span>
          </a>
        </li>
      </ul>
    @endif
  </nav>
</aside>



    <style>
      .logo-dashboard {
        max-width: 100%; /* Membuat gambar tidak lebih besar dari kontainer */
        height: auto; /* Mempertahankan rasio gambar */
        display: block;
      }

      .img-fit-menu {
        width: 200px; /* Sesuaikan ukuran yang diinginkan untuk menu */
        height: 100px; /* Sesuaikan tinggi yang diinginkan untuk menu */
        object-fit: contain; /* Memastikan gambar pas tanpa terpotong */
        margin: 0 auto; /* Center image jika diperlukan */
      }
    </style>
</body>
