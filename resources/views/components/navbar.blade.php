<header>
    <div class="topbar">
        <div class="social-icons">
            <a href="https://www.instagram.com/diskominfobdg/?hl=en" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
            <a href="https://x.com/diskominfobdg" target="_blank" rel="noopener noreferrer"><i class="fab fa-x-twitter"></i></a>
            <a href="https://www.facebook.com/DiskominfoBandung/" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.youtube.com/@diskominfokotabandung" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
            <a href="https://www.tiktok.com/@humasbdg" target="_blank" rel="noopener noreferrer"><i class="fab fa-tiktok"></i></a>
        </div>
        <div class="office-hours">Jam Beroperasi Senin - Jumat: 8.00 am - 6.00 pm</div>
        <div class="search-box">
            <form action="{{ route('berita.index') }}" method="GET" class="flex">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari berita ..."
                    class="text-sm px-2 py-1 border rounded-l-md focus:outline-none" />
                <button type="submit" class="bg-blue-600 text-white px-3 rounded-r-md">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>

    </div>

    <nav class="main-nav">
        <div class="logo">
            <img src="{{ asset('pictures/logo_diskominfo.png') }}" alt="Diskominfo Logo" />
        </div>
        <button class="menu-toggle" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </button>
        <ul class="nav-links">
            <li><a href="{{route('home')}}">Beranda</a></li>
            <li class="dropdown">
                <a href="#">Profile <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{route('sejarah.index')}}">Sejarah</a></li>
                    <li><a href="{{route('showPublic') }}">Visi Misi</a></li>
                    <li><a href="{{route('profile.strukturOrganisasi')}}">Struktur Organisasi</a></li>
                    <li><a href="{{route('tupoksi') }}">Tupoksi</a></li>
                    <li><a href="{{route('profile.show')}}">Profil Pimpinan</a></li>
                </ul>
            </li>
            <li><a href="{{route('berita.index')}}">Berita</a></li>
            <li class="dropdown">
                <a href="#">Galeri <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{route('main.galeri.foto')}}">Foto</a></li>
                    <li><a href="{{route('main.galeri.video')}}">Video</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Informasi <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{route('dokumen.index')}}">Dokumen Informasi</a></li>
                    <li><a href="{{route('agenda.index')}}">Agenda</a></li>
                    <li><a href="{{route('pengumuman.index')}}">Pengumuman</a></li>
                    <li><a href="{{ route('aplikasi.show', 'opendata') }}">Open Data</a></li>
                    <li><a href="{{ route('aplikasi.show', 'kim') }}">Kelompok Informasi Masyarakat</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">PPID <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li class="submenu-parent">
                        <a href="#">Tentang PPID <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="{{ route('ppid.show.text', 'profile-ppid-diskominfo') }}">Profil PPID DISKOMINFO</a></li>
                            <li><a href="{{ route('ppid.show.text', 'agenda-ppid') }}">Agenda PPID</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Setiap Saat<i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="{{ route('ppid.show', 'informasi-mengenai-daftar-informasi-publik') }}">Informasi Mengenai Daftar Informasi Publik</a></li>
                            <li><a href="{{ route('ppid.show', 'informasi-mengenai-surat-perjanjian-dengan-pihak-ketiga') }}">Informasi Mengenai Surat Perjanjian dengan Pihak Ketiga</a></li>
                            <li><a href="{{route('profile.strukturOrganisasi')}}">Informasi tentang Organisasi, Administrasi, Kepegawaian dan Keuangan</a></li>
                            <li><a href="{{ route('ppid.show', 'pedoman-pelayanan-publik') }}">Pedoman Pelayanan Publik</a></li>
                            <li><a href="{{ route('ppid.show', 'jumlah-jenis-gambaran-umum-pengaduan') }}">Jumlah, Jenis, Gambaran Umum Pengaduan</a></li>
                            <li><a href="{{ route('ppid.show', 'laporan-pelayanan-informasi') }}">Laporan Pelayanan Informasi</a></li>
                            <li><a href="{{ route('ppid.show', 'laporan-data-aset') }}">Laporan Data Aset</a></li>
                            <li><a href="{{ route('ppid.show', 'standar-pelayanan') }}">Standar Pelayanan</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Berkala<i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="#">Informasi DISKOMINFO</a></li>
                            <li class="submenu-parent">
                                <a href="#">Kegiatan dan Kinerja<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="{{ route('ppid.show', 'laporan-akuntabilitas-kerja') }}">Laporan Akuntabilitas Kerja</a></li>
                                    <li><a href="{{ route('ppid.show', 'program-dan-kegiatan') }}">Program dan Kegiatan</a></li>
                                    <li><a href="{{ route('ppid.show', 'daftar-penanggung-jawab-pelaksanaan-program') }}">Daftar Penanggung Jawab Pelaksanaan Program</a></li>
                                    <li><a href="{{ route('ppid.show', 'target-dan-atau-capaian-program-dan-kegiatan') }}">Target dan/atau Capaian Program dan Kegiatan</a></li>
                                    <li><a href="{{ route('ppid.show', 'anggaran-program-dan-kegiatan') }}">Anggaran Program dan Kegiatan</a></li>
                                    <li><a href="{{ route('ppid.show', 'realisasi-kegiatan') }}">Realisasi Kegiatan</a></li>
                                </ul>
                            </li>
                            <li class="submenu-parent">
                                <a href="#">Keuangan DISKOMINFO<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="{{ route('ppid.show', 'laporan-keuangan-berupa-rencana-dan-laporan-realisasi-anggaran') }}">Laporan Keuangan berupa Rencana dan Laporan Realisasi Anggaran</a></li>
                                    <li><a href="{{ route('ppid.show', 'laporan-keuangan-berupa-laporan-arus-kas-dan-catatan-atas-laporan-keuangan') }}">Laporan Keuangan berupa Laporan Arus Kas dan Catatan atas Laporan Keuangan</a></li>
                                    <li><a href="{{ route('ppid.show', 'laporan-keuangan-berupa-daftar-aset-dan-informasi') }}">Laporan Keuangan berupa Daftar Aset dan Informasi</a></li>
                                    <li><a href="{{ route('ppid.show', 'informasi-rencana-kerja-dan-anggaran') }}">Informasi Rencana Kerja dan Anggaran</a></li>
                                </ul>
                            </li>
                            <li class="submenu-parent">
                                <a href="#">Investasi<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="{{ route('ppid.show', 'realisasi-investasi') }}">Realisasi Investasi</a></li>
                                </ul>
                            </li>
                            <li class="submenu-parent">
                                <a href="#">Laporan Akses Informasi Publik<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="{{ route('ppid.show', 'register-keberatan-informasi') }}">Register Keberatan Informasi</a></li>
                                    <li><a href="{{ route('ppid.show', 'register-permohonan-informasi') }}">Register Permohonan Informasi</a></li>
                                    <li><a href="{{ route('ppid.show', 'jumlah-permohonan-informasi') }}">Jumlah Permohonan Informasi</a></li>
                                </ul>
                            </li>
                            <li class="submenu-parent">
                                <a href="#">Tata Cara Permohonan Informasi Publik<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="{{ route('ppid.show', 'sop-pelayanan-informasi-publik') }}">SOP Pelayanan Informasi Publik</a></li>
                                    <li><a href="{{ route('ppid.show', 'permohonan-informasi-publik') }}">Permohonan Informasi Publik</a></li>
                                    <li><a href="{{ route('ppid.show', 'formulir-keberatan-informasi-publik') }}">Formulir Keberatan Informasi Publik</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('ppid.show', 'informasi-tata-cara-permohonan-dan-pengaduan') }}">Informasi Tata Cara Permohonan dan Pengaduan</a></li>
                            <li><a href="{{ route('ppid.show', 'rencana-strategis-dan-rencana-kerja') }}">Rencana Strategis dan Rencana Kerja</a></li>
                            <li><a href="{{ route('ppid.show', 'regulasi-diskominfo') }}">Regulasi DISKOMINFO</a></li>
                            <li><a href="{{ route('ppid.show', 'daftar-informasi-publik') }}">Daftar Informasi Publik</a></li>
                            <li><a href="{{ route('ppid.show', 'daftar-pejabat-ppid') }}">Daftar Pejabat PPID</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Serta Merta <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="">Laporan Realisasi Penerimaan Informasi</a></li>
                            <li><a href="">Pengadaan Barang dan Jasa</a></li>
                            <li><a href="">Pengumuman</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Dikecualikan <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="{{ route('ppid.show', 'daftar-informasi-dikecualikan') }}">Daftar Informasi Dikecualikan</a></li>
                            <li><a href="{{ route('ppid.show', 'ikepwal-daftar-informasi-dikecualikan') }}">Kepwal Daftar Informasi Dikecualikan</a></li>
                        </ul>
                    </li>
                    <li><a href="https://ppid-simonik.bandung.go.id/pilih-permohonan">Permohonan Informasi Online</a></li>
                    <li><a href="https://ppid.bandung.go.id/">PPID Utama</a></li>
                    <li><a href="http://ppid-simonik.bandung.go.id/input-keberatan">Pengajuan Keberatan Online</a></li>
                    <li><a href="bandung.go.id">Portal Kota Bandung</a></li>
                    <li><a href="">SOP Peringatan Dini</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Layanan <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('aplikasi.show', 'opd') }}">Layanan OPD</a></li>
                    <li><a href="{{route('kunjungan.index')}}">Kunjungan</a></li>
                    <li><a href="#">Penelitian, Survey, Magang/PKL</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Pengaduan <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('aplikasi.show', 'lapor') }}">SP4N Lapor</a></li>
                    <li><a href="{{ route('aplikasi.show', 'wbs') }}">Whistle Blowing System</a></li>
                    <li><a href="{{ route('aplikasi.show', 'csirt') }}">BandungKota-CSIRT Aduan Siber</a></li>
                </ul>
            </li>
            <li><a href="#">Hubungi Kami</a></li>
        </ul>
    </nav>

    <script>
        function toggleMenu() {
            document.querySelector('.nav-links').classList.toggle('active');
        }

        document.addEventListener("DOMContentLoaded", () => {
            const isMobile = () => window.innerWidth < 768;

            document.querySelectorAll('.dropdown > a').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (isMobile()) {
                        e.preventDefault();
                        this.parentElement.classList.toggle('open');
                    }
                });
            });

            document.querySelectorAll('.submenu-parent > a').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (isMobile()) {
                        e.preventDefault();
                        this.parentElement.classList.toggle('open');
                    }
                });
            });
        });
    </script>


</header>