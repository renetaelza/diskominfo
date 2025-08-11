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
        <button class="menu-toggle" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </button>
        <ul class="nav-links">
            <li><a href="{{route('landing')}}">Beranda</a></li>
            <li class="dropdown">
                <a href="#">Profile <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{route('sejarah.index')}}">Sejarah</a></li>
                    <li><a href="#">Sasaran dan Tujuan</a></li>
                    <li><a href="{{route('profile.strukturOrganisasi')}}">Struktur Organisasi</a></li>
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
                    <li><a href="{{route('agenda.index')}}">Agenda</a></li>
                    <li><a href="#">Pengumuman</a></li>
                    <li><a href="{{route('opendata.index')}}">Open Data</a></li>
                    <li><a href="{{route('kim.index')}}">Kelompok Informasi Masyarakat</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">PPID <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li class="submenu-parent">
                        <a href="#">Tentang PPID <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="https://dpmptsp.bandung.go.id/detail-pages/profil-ppid-dpmptsp-kota-bandung.html">Profil PPID DPMPTSP</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/detail-pages/agenda-ppid.html">Agenda PPID</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Berkala <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="https://dpmptsp.bandung.go.id/profil.html">Informasi Profile DPMPTSP</a></li>
                            <li class="submenu-parent">
                                <a href="#">Kegiatan dan Kinerja<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/laporan-akuntabilitas-kerja.html">Laporan Akuntabilitas Kerja</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/program-dan-kegiatan.html">Nama Program dan/atau Kegiatan</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/daftar-penanggung-jawab-pelaksana-program-dan-kegiatan.html">Daftar Penanggung Jawab, Pelaksana Program dan Kegiatan</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/target-danatau-capaian-program-dan-kegiatan.html">Target dan/atau Capaian Program dan Kegiatan</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/realisasi-kegiatan-dpmptsp.html">Anggaran Program dan Kegiatan</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/realisasi-kegiatan-dpmptsp.html">Realisasi Kegiatan</a></li>
                                </ul>
                            </li>
                            <li class="submenu-parent">
                                <a href="#">Keuangan DPMPTSP<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/realisasi-kegiatan-dpmptsp.html">Laporan Keuangan berupa Rencana dan Laporan Realisasi Anggaran</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/laporan-keuangan-berupa-rencana-dan-laporan-realisasi-anggaran.html">Laporan Keuangan berupa Laporan Arus Kas dan Catatan atas Laporan Keuangan</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/laporan-keuangan-berupa-laporan-arus-kas-dan-catatan-atas-laporan-keuangan.html">Daftar Penanggung Jawab, Pelaksana Program dan Kegiatan</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/index.html#">Laporan Keuangan berupa Daftar Aset dan Investasi</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/rencana-kerja-renja-dpmptsp-kota-bandung.html">Informasi Rencana Kerja Rencana Kerja dan Anggaran</a></li>
                                </ul>
                            </li>
                            <li class="submenu-parent">
                                <a href="#">Laporan Akses Informasi Publik<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="https://dpmptsp.bandung.go.id/index.html#">Register Keberatan Informasi</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/index.html#">Register Permohonan Informasi</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/index.html#">Jumlah Permohonan Informasi</a></li>
                                </ul>
                            </li>
                            <li class="submenu-parent">
                                <a href="#">Tata Cara Permohonan Informasi Publik<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="https://dpmptsp.bandung.go.id/index.html#">Standar Operasional Prosedur Pelayanan Informasi Publik</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/permintaan-informasi-publik">Permohonan Informasi Publik</a></li>
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/formulir-keberatan-informasi.html">Formulir Keberatan Informasi Publik</a></li>
                                </ul>
                            </li>
                            <li class="submenu-parent">
                                <a href="#">Investasi<i class="fa fa-caret-right"></i></a>
                                <ul class="dropdown-submenu">
                                    <li><a href="https://dpmptsp.bandung.go.id/detail-pages/realisasi-investasi.html">Realisasi Investasi</a></li>
                                </ul>
                            </li>

                            <li><a href="https://dpmptsp.bandung.go.id/detail-pages/informasi-mengenai-tata-cara-permohonan-informasi-dan-pengaduan.html">Informasi Mengenai Tata Cara Permohonan Informasi dan Pengaduan</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/detail-pages/rencana-strategis-dan-rencana-kerja.html">Rencana Strategis dan Rencana Kerja</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/detail-dokumen-informasi/regulasi.html">Regulasi DPMPTSP</a></li>
                        </ul>
                    </li>

                    <li class="submenu-parent">
                        <a href="#">Informasi Setiap Saat<i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="https://dpmptsp.bandung.go.id/index.html">Informasi Mengenai Daftar Informasi Publik</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/detail-pages/informasi-mengenai-surat-perjanjian-dengan-pihak-ketiga.html">Informasi Mengenai Surat Perjanjian dengan Pihak Ketiga</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/struktur-organisasi.html">Informasi Tentang Organisasi, Administrasi, Kepegaawaian dan Keuangan</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/detail-pages/pedoman-pelayanan-publik.html">Pedoman Pelayanan Publik</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/index.html">Jumlah, Jenis dan Gambaran Umum Pengaduan</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/detail-pages/laporan-pelayanan-informasi.html">Laporan Pelayanan Informasi</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Serta Merta <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="https://dpmptsp.bandung.go.id/index.html">Laporan Realisasi Penerimaan Restribusi</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/index.html">Pengadaan Barang dan Jasa</a></li>
                            <li><a href="https://dpmptsp.bandung.go.id/detail-pages/pengumuman.html">Pengumuman</a></li>
                        </ul>
                    </li>
                    <li class="submenu-parent">
                        <a href="#">Informasi Dikecualikan <i class="fa fa-caret-right"></i></a>
                        <ul class="dropdown-submenu">
                            <li><a href="https://ppid.bandung.go.id/storage/ppid_utama/nwZpmz3UyP8VRB0c2sEdKcAjAnuBUYiNoFOuuPb9.pdf">Kepwal Daftar Informasi Dikecualikan</a></li>
                            <li><a href="https://ppid.bandung.go.id/storage/ppid_utama/rOJxMBTh9exy7lJg67AoXeuBKUsVtbJmNqbqZm1G.pdf">Daftar Informasi Dikecualikan</a></li>
                        </ul>
                    </li>
                    <li><a href="http://ppid-simonik.bandung.go.id/pilih-permohonan">Permohonan Informasi Online</a></li>
                    <li><a href="http://ppid-simonik.bandung.go.id/input-keberatan">Pengajuan Keberatan Online</a></li>
                    <li><a href="https://ppid.bandung.go.id/">PPID Utama</a></li>
                    <li><a href="https://bandung.go.id/">PORTAL Kota Bandung</a></li>
                    <li><a href="https://dpmptsp.bandung.go.id/web-external-asset/file/file-manager/2023-08-24_5jUf_SOP_Kebakaran_dan_Gempa_Bumi.pdf">SOP Peringatan Dini dan Evakuasi Darurat</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Layanan <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{route('opd.index')}}">Layanan OPD</a></li>
                    <li><a href="#">Kunjungan</a></li>
                    <li><a href="#">Penelitian, Survey, Magang/PKL</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Pengaduan <i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="{{route('lapor.index')}}">SP4N Lapor</a></li>
                    <li><a href="{{route('wbs.index')}}">Whistle Blowing System</a></li>
                    <li><a href="{{route('csirt.index')}}">BandungKota-CSIRT Aduan Siber</a></li>
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