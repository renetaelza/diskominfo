<header>
    <div class="topbar">
        <div class="social-icons">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-x-twitter"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <div class="office-hours">Jam Beroperasi Senin - Jumat: 8.00 am - 6.00 pm</div>
        <div class="search-box">
            <input type="text" placeholder="Cari berita ..." style="font-size: 12px;" />
            <button><span>&#128269;</span></button>
        </div>
    </div>

    <nav class="main-nav">
        <div class="logo">
            <img src="{{ asset('pictures/logo_diskominfo.png') }}" alt="Diskominfo Logo" />
        </div>
        <ul class="nav-links">
            <li class="dropdown">
                <a href="#">Profile <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Sejarah</a></li>
                    <li><a href="#">Sasaran dan Tujuan</a></li>
                    <li><a href="#">Struktur Organisasi</a></li>
                    <li><a href="#">Tupoksi</a></li>
                    <li><a href="#">Profil Pimpinan</a></li>
                </ul>
            </li>
            <li><a href="{{route('berita.index')}}">Berita</a></li>
            <li class="dropdown">
                <a href="#">Galeri <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Gambar</a></li>
                    <li><a href="#">Video</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Informasi <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Dokumen Informasi</a></li>
                    <li><a href="#">Agenda</a></li>
                    <li><a href="#">Pengumuman</a></li>
                    <li><a href="#">Open Data</a></li>
                    <li><a href="#">Kelompok Informasi Masyarakat</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">PPID <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li class="submenu-parent">
                        <a href="#">Tentang PPID <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="#">Profil PPID DPMPTSP</a></li>
                            <li><a href="#">Agenda PPID</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Berkala <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="#">Laporan Tahunan</a></li>
                            <li class="submenu-parent">
                                <a href="#">Rencana Kerja <i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="#">RK Tahun 2024</a></li>
                                    <li><a href="#">RK Tahun 2025</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="submenu-parent">
                        <a href="#">Informasi Setiap Saat<i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="#">Dokumen Hukum</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Serta Merta <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="#">Bencana & Darurat</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Dikecualikan <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="#">Data Rahasia</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Permohonan Informasi Online</a></li>
                    <li><a href="#">Pengajuan Keberatan Online</a></li>
                    <li><a href="#">PPID Utama</a></li>
                    <li><a href="#">PORTAL Kota Bandung</a></li>
                    <li><a href="#">SOP Peringatan Dini dan Evakuasi Darurat</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Layanan <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Layanan OPD</a></li>
                    <li><a href="#">Kunjungan</a></li>
                    <li><a href="#">Penelitian, Survey, Magang/PKL</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Pengaduan <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#">SP4N Lapor</a></li>
                    <li><a href="#">Whistle Blowing System</a></li>
                    <li><a href="#">BandungKota-CSIRT Aduan Siber</a></li>
                </ul>
            </li>
            <li><a href="#">Hubungi Kami</a></li>
        </ul>
    </nav>
</header>
