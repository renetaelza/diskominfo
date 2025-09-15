<footer class="relative bg-zinc-800 text-white pt-10 pb-6 overflow-hidden font-poppins">
    <!-- Background -->
    <div class="absolute inset-0 bg-cover bg-center opacity-25 z-0" style="background-image: url('{{ asset('pictures/bg-footer.jpg') }}');"></div>

    <!-- Konten Utama -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-3 gap-12">
        
        <!-- Logo dan Kontak -->
        <div class="mt-2">
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('pictures/logo_diskominfo2.png') }}" alt="Logo Diskominfo" class="w-14 h-14 object-contain">
                </div>
            </div>
            <ul class="space-y-3 text-sm font-medium">
                <li class="flex items-start gap-2 mb-4">
                <i class="fas fa-map-marker-alt mt-1"></i>
                <span>Jl. Wastukencana No.2, Babakan Ciamis, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40117</span>
                </li>
                <li class="flex items-center gap-2 mb-4">
                <i class="fas fa-phone-alt"></i>
                <span>0821-7173-8467</span>
                </li>
                <li class="flex items-center gap-2 mb-4">
                <i class="fas fa-envelope"></i>
                <span>diskominfo@bandung.go.id</span>
                </li>
            </ul>
        </div>

        <!-- Layanan -->
        <div class="mt-10">
            <h3 class="text-lg font-semibold mb-4">Layanan</h3>
            <ul class="space-y-3 text-sm font-normal">
                <li><a href="https://smartcity.bandung.go.id/" target="_blank" rel="noopener noreferrer" class="hover:text-orange-400 transition duration-300">Bandung Smart City</a></li>
                <li><a href="https://opendata.bandung.go.id/" target="_blank" rel="noopener noreferrer" class="hover:text-orange-400 transition duration-300">Open Data Kota Bandung</a></li>
                <li><a href="https://ppid.bandung.go.id/"  class="hover:text-orange-400 transition duration-300">PPID Kota Bandung</a></li>
                <li><a href="https://www.lapor.go.id/"  class="hover:text-orange-400 transition duration-300">Layanan Aspirasi</a></li>
                <li><a href="https://play.google.com/store/apps/details?id=gov.bdg.smartcitybdg" target="_blank"  class="hover:text-orange-400 transition duration-300">Unduh Layanan Digital</a></li>
            </ul>
        </div>

        <!-- Google Maps -->
        <div class="mt-10">
            <h3 class="text-lg font-semibold mb-4">Lokasi Kami</h3>
            <div class="w-full h-64 rounded-lg overflow-hidden shadow-lg">
                <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.832079879284!2d107.60674967581288!3d-6.910672267636197!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e63a04b86947%3A0x588f28f53e8076c0!2sDiskominfo%20Bandung!5e0!3m2!1sen!2sid!4v1752756729384!5m2!1sen!2sid"
                width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

  <!-- Sosial Media -->
  <div class="relative z-10 mt-10 flex justify-center space-x-6 text-xl">
    <a href="https://www.instagram.com/diskominfobdg/?hl=en" target="_blank" rel="noopener noreferrer" class="hover:text-orange-400 transition duration-300"><i class="fab fa-instagram"></i></a>
    <a href="https://x.com/diskominfobdg" target="_blank" rel="noopener noreferrer" class="hover:text-orange-400 transition duration-300"><i class="fab fa-x-twitter"></i></a>
    <a href="https://www.facebook.com/DiskominfoBandung/" target="_blank" rel="noopener noreferrer" class="hover:text-orange-400 transition duration-300"><i class="fab fa-facebook-f"></i></a>
    <a href="https://www.youtube.com/@diskominfokotabandung" target="_blank" rel="noopener noreferrer" class="hover:text-orange-400 transition duration-300"><i class="fab fa-youtube"></i></a>
    <a href="https://www.tiktok.com/@humasbdg" target="_blank" rel="noopener noreferrer" class="hover:text-orange-400 transition duration-300"><i class="fab fa-tiktok"></i></a>
  </div>

  <!-- Garis & Copyright -->
  <div class="relative z-10 mt-6 border-t border-orange-400"></div>
  <div class="relative z-10 pt-4 text-center text-sm font-bold">
    © Dinas Komunikasi dan Informatika Kota Bandung 2025
  </div>
</footer>
