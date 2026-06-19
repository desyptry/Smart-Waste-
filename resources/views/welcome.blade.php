<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> 
        Smart Waste
    </title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body>
    
<header id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300">
    <!-- Navbar Container -->
    <div id="nav-bg" class="absolute inset-0 bg-white md:bg-transparent -z-10 transition-all duration-300"></div>
    
    <div class="container mx-auto flex items-center justify-between px-6 py-4 relative">
        <!-- Logo -->
        <div class="logo shrink-0">
            <a href="#">
                <img src="{{asset('images/logo.png')}}" alt="Logo" class="h-10">
            </a>
        </div>

        <!-- Hamburger Icon (Mobile) -->
        <div class="md:hidden">
            <button id="menu-btn" class="text-slate-800 focus:outline-none p-2">
                <svg id="hamburger-icon" class="w-8 h-8 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>

        <!-- Menu Navigation -->
        <ul id="menu" class="hidden absolute top-full left-0 w-full bg-white flex-col p-5 md:p-0 gap-2 shadow-xl md:shadow-none md:static md:w-auto md:bg-transparent md:flex md:flex-row md:gap-8 text-slate-800 font-bold items-center">
            <li class="w-full md:w-auto text-center py-2 hover:text-[#69C3C1] transition-colors"><a href="#">Dashboard</a></li>
            <li class="w-full md:w-auto text-center py-2 hover:text-[#69C3C1] transition-colors"><a href="#about-us">Tentang</a></li>
            <li class="w-full md:w-auto text-center py-2 hover:text-[#69C3C1] transition-colors"><a href="#faq">FAQ</a></li>
            <li class="w-full md:w-auto text-center py-2 hover:text-[#69C3C1] transition-colors"><a href="#location">Lokasi</a></li>
            
            <div class="h-[1px] w-full bg-gray-100 my-2 md:hidden"></div>
            
            <li class="w-full md:w-auto">
                <a href="#" class="block text-center px-8 py-2.5 border-2 border-[#69C3C1] text-[#69C3C1] rounded-full hover:bg-[#69C3C1] hover:text-white transition-all font-bold">Daftar</a>
            </li>
            <li class="w-full md:w-auto">
                <a href="#" class="block text-center px-8 py-2.5 bg-[#69C3C1] text-white rounded-full hover:bg-[#58a8a6] shadow-lg shadow-cyan-100 transition-all font-bold">Login</a>
            </li>
        </ul>
    </div>
</header>
<main>
<section id="hero" class="bg-linear-to-t to-(--gradient-blue) from-white w-full min-h-[500px] flex items-center overflow-hidden pt-20" >
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between">
            
            <!-- Sisi Kiri: Teks Content -->
            <div class="w-full md:w-1/2 flex flex-col gap-4 py-10 md:py-0 text-center md:text-left ">
                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-800 leading-tight">
                    Pandu pintar <br> mengolah sampah
                </h1>
                <p class="text-slate-500 text-lg leading-relaxed">
                    Mulai bermanfaat untuk diri dan orang sekitar dengan memanfaatkan fitur dari aplikasi Bank Sampah
                </p>
                
                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-4">
                    <a href="{{route('register')}}" class="px-8 py-3 bg-[#69C3C1] hover:bg-[#58a8a6] text-white font-bold rounded-full transition-all shadow-lg shadow-cyan-100">
                        Mulai Mengolah Sampah
                    </a>
                    <a href="#about" class="px-8 py-3 bg-(--primary) hover:bg-[#a2c9aa] text-white font-bold rounded-full transition-all shadow-lg shadow-green-100">
                        Tentang Kami
                    </a>
                  
                </div>
            </div>
            <!-- Sisi Kanan: Image -->
            <div class="w-full md:w-1/2 relative flex justify-end">
                <!-- Ilustrasi garis rumah di belakang (opsional/dekoratif) -->
                <div class="absolute right-0 bottom-0 opacity-20 -z-10">
                    <svg width="400" height="400" viewBox="0 0 24 24" fill="none" stroke="#2D7A4D" stroke-width="0.5">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    </svg>
                </div>
                
                <img src="{{ asset('images/orang.png') }}" 
                     alt="Pandu Pintar" 
                     class="w-full max-w-[500px] object-contain">
            </div>

        </div>
</div>
</section>
<section id="why-choose-us" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <!-- Header Text -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <p class="text-gray-600 text-lg md:text-xl leading-relaxed">
                Revolusi lingkungan kami, ubah pandanganmu tentang sampah. Edukasi, pemilahan, dan kolaborasi membangun masa depan hijau bersama!
            </p>
            <h2 class="text-2xl font-black text-slate-800 mt-2">#SETORinAja</h2>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Card 1: Informasi Terkini -->
            <div class="bg-[#F4F9FC] p-10 rounded-3xl text-center flex flex-col items-center group hover:shadow-xl transition-all duration-300">
                <div class="w-20 h-20 mb-6 flex items-center justify-center relative">
                    <!-- Ikon menggunakan placeholder atau Blade Icon -->
                    <x-mdi-information-variant class="w-16 h-16 text-[#69C3C1]"/>
                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-yellow-400 rounded-full border-4 border-[#F4F9FC]"></div>
                </div>
                <h3 class="font-extrabold text-slate-800 mb-4">Informasi Terkini</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Dapatkan konten informasi dan berita mengenai Bank Sampah dari sumber terpercaya
                </p>
            </div>

            <!-- Card 2: Setor dengan Mudah -->
            <div class="bg-[#F4F9FC] p-10 rounded-3xl text-center flex flex-col items-center group hover:shadow-xl transition-all duration-300">
                <div class="w-20 h-20 mb-6 flex items-center justify-center relative">
                    <x-mdi-email-check-outline class="w-16 h-16 text-[#69C3C1]"/>
                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-yellow-400 rounded-full border-4 border-[#F4F9FC]"></div>
                </div>
                <h3 class="font-extrabold text-slate-800 mb-4">Setor dengan Mudah</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Menyetor dengan cepat kini nasabah bisa melihat riwayat setoran mereka secara langsung
                </p>
            </div>

            <!-- Card 3: Pantau Riwayat -->
            <div class="bg-[#F4F9FC] p-10 rounded-3xl text-center flex flex-col items-center group hover:shadow-xl transition-all duration-300">
                <div class="w-20 h-20 mb-6 flex items-center justify-center relative">
                    <x-mdi-chart-bar class="w-16 h-16 text-[#69C3C1]"/>
                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-yellow-400 rounded-full border-4 border-[#F4F9FC]"></div>
                </div>
                <h3 class="font-extrabold text-slate-800 mb-4">Pantau Riwayat</h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Riwayat penarikan memberikan kemudahan bagi nasabah untuk mengelola keuangan
                </p>
            </div>

        </div>
    </div>
</section>
<section id="about-us" class="py-20 bg-white overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12 md:gap-20">
            
            <!-- Sisi Kiri: Gambar -->
            <div class="w-full md:w-1/2 relative">
                <!-- Dekorasi lingkaran halus di belakang gambar (opsional) -->
                <div class="absolute -top-10 -left-10 w-64 h-64 bg-green-50 rounded-full -z-10 blur-3xl opacity-60"></div>
                
                <div class="rounded-3xl overflow-hidden shadow-2xl transform md:-rotate-2 hover:rotate-0 transition-transform duration-500">
                    <!-- Gunakan placeholder atau gambar person holding box -->
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&q=80&w=800" 
                         alt="Mengenal Bank Sampah" 
                         class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Sisi Kanan: Konten Teks -->
            <div class="w-full md:w-1/2 space-y-6">
                <h2 class="text-4xl md:text-5xl font-black text-slate-800 leading-[1.1]">
                    Mengenal Bank Sampah <br> 
                    <span class="text-slate-800/90">dengan lebih dekat</span>
                </h2>
                
                <div class="space-y-4 text-gray-500 leading-relaxed">
                    <p class="text-lg">
                        Bank Sampah Smart Waste, berdiri sejak 4 Januari 2019, mendedikasikan diri untuk mengubah pandangan tentang sampah.
                    </p>
                    <p class="text-lg">
                        Berfokus pada edukasi dan pengelolaan sampah yang bijak, kami menciptakan lingkungan masyarakat yang lebih baik.
                    </p>
                </div>

                <div class="pt-4">
                    <a href="#" class="inline-block px-10 py-3 bg-(--primary) hover:bg-[#a2c9aa] text-white font-bold rounded-full transition-all shadow-lg shadow-green-100">
                        Tentang Kami
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
<section id="faq" class="py-20 bg-[#F4F9FC]">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 max-w-5xl mx-auto">
            <h2 class="text-xl font-black text-slate-800 mb-8 uppercase tracking-wider">FAQ</h2>
            
            <div class="space-y-6">
                <!-- Item FAQ 1 -->
                <div class="faq-item border-b border-gray-100 pb-4">
                    <div class="faq-question flex justify-between items-center cursor-pointer group">
                        <p class="text-gray-600 font-medium group-hover:text-slate-800 transition-colors">
                            Apa itu Bank Sampah?
                        </p>
                        <x-mdi-chevron-down class="faq-icon w-5 text-gray-400 group-hover:text-(--primary) transition-transform duration-300"/>
                    </div>
                    <div class="faq-answer hidden mt-4 text-gray-500 text-sm leading-relaxed">
                        Bank sampah adalah tempat pemilahan dan pengumpulan sampah yang dapat didaur ulang dan/atau diguna ulang yang memiliki nilai ekonomi. Di sini, masyarakat bisa menyetor sampah dan mendapatkan saldo yang bisa dicairkan.
                    </div>
                </div>

                <!-- Item FAQ 2 -->
                <div class="faq-item border-b border-gray-100 pb-4">
                    <div class="faq-question flex justify-between items-center cursor-pointer group">
                        <p class="text-gray-600 font-medium group-hover:text-slate-800 transition-colors">
                            Sampah apa saja yang diterima di Bank Sampah?
                        </p>
                        <x-mdi-chevron-down class="faq-icon w-5 text-gray-400 group-hover:text-(--primary) transition-transform duration-300"/>
                    </div>
                    <div class="faq-answer hidden mt-4 text-gray-500 text-sm leading-relaxed">
                        Kami menerima berbagai jenis sampah anorganik seperti plastik (botol minum, ember), kertas (koran, kardus), logam (besi, aluminium), dan botol kaca. Pastikan sampah dalam kondisi bersih dan kering.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="counter" class="bg-[#A8D1B7] py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-4">
            
            <!-- Item 1: Unit Bank Sampah -->
            <div class="flex items-center justify-center md:justify-start gap-5">
                <div class="w-16 h-16 bg-[#FFB319] rounded-full flex items-center justify-center shadow-sm">
                    <x-mdi-star class="w-7 h-7 text-black"/>
                </div>
                <div class="flex flex-col">
                    <h3 class="text-lg font-bold text-black leading-tight">Unit Bank Sampah</h3>
                    <p class="text-3xl font-black text-black">5</p>
                </div>
            </div>

            <!-- Item 2: Nasabah -->
            <div class="flex items-center justify-center md:justify-start gap-5">
                <div class="w-16 h-16 bg-[#FFB319] rounded-full flex items-center justify-center shadow-sm">
                    <x-mdi-account-group class="w-7 h-7 text-black"/>
                </div>
                <div class="flex flex-col">
                    <h3 class="text-lg font-bold text-black leading-tight">Nasabah</h3>
                    <p class="text-3xl font-black text-black">551</p>
                </div>
            </div>

            <!-- Item 3: Terkelolah (Kg) -->
            <div class="flex items-center justify-center md:justify-start gap-5">
                <div class="w-16 h-16 bg-[#FFB319] rounded-full flex items-center justify-center shadow-sm">
                    <x-mdi-check-bold class="w-7 h-7 text-black"/>
                </div>
                <div class="flex flex-col">
                    <h3 class="text-lg font-bold text-black leading-tight">Terkelolah (Kg)</h3>
                    <p class="text-3xl font-black text-black">66530.58</p>
                </div>
            </div>

        </div>
    </div>
</section>
<section id="location" class="py-20 bg-white overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
            
            <!-- Sisi Kiri: Konten Teks -->
            <div class="w-full md:w-1/2 space-y-6 order-2 md:order-1">
                <h2 class="text-4xl md:text-5xl font-black text-slate-800 leading-tight">
                    Jadi hero lingkungan <br> bersama kami
                </h2>
                
                <div class="space-y-4 text-gray-500 text-lg leading-relaxed">
                    <p>
                        Bank Sampah Smart Waste telah meraih pengakuan dan penghargaan dari berbagai pihak atas kontribusi kami dalam menjaga kebersihan lingkungan.
                    </p>
                    <p>
                        Bergabunglah dalam misi keberlanjutan Smart Waste! <br>
                        <span class="text-[#69C3C1] font-bold">#SETORinAja</span> sampahmu untuk menciptakan lingkungan yang lebih baik!
                    </p>
                </div>

                <div class="pt-4">
                    <a href="#map-location" class="inline-block px-10 py-3 bg-(--primary) hover:bg-[#a2c9aa] text-white font-bold rounded-full transition-all shadow-lg shadow-green-100">
                        Lihat Lokasi
                    </a>
                </div>
            </div>

            <!-- Sisi Kanan: Kolase Foto Aktivitas -->
            <div class="w-full md:w-1/2 relative order-1 md:order-2 h-[400px] md:h-[500px]">
                <!-- Foto Utama (Tengah) -->
                <div class="absolute left-0 top-10 w-2/3 z-20 transform -rotate-2">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&q=80&w=600" 
                         class="rounded-2xl shadow-xl border-4 border-white object-cover h-64 w-full" alt="Aktivitas 1">
                </div>
                
                <!-- Foto Kanan Atas -->
                <div class="absolute right-0 top-0 w-1/2 z-10">
                    <img src="https://images.unsplash.com/photo-1530587191325-3db32d826c18?auto=format&fit=crop&q=80&w=400" 
                         class="rounded-2xl shadow-lg border-4 border-white object-cover h-48 w-full" alt="Aktivitas 2">
                </div>

                <!-- Foto Kanan Bawah -->
                <div class="absolute right-4 bottom-0 w-3/5 z-30 transform rotate-3">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&q=80&w=600" 
                         class="rounded-2xl shadow-2xl border-4 border-white object-cover h-56 w-full" alt="Aktivitas 3">
                </div>
            </div>

        </div>
    </div>
</section>
    <section id="map-location" class="w-full bg-white">
    <div class="container mx-auto px-4 mb-8 text-center md:text-left">
        <h2 class="text-2xl font-black text-center text-slate-800">
            Jangkauan <span class="text-[#69C3C1]">Bank Sampah</span> Kami
        </h2>
        <p class="text-gray-500 text-center mt-2">Temukan titik drop-off terdekat dari lokasi Anda di seluruh Indonesia.</p>
    </div>

    <!-- Container Peta -->
    <div class="w-full h-[450px] md:h-[600px] relative shadow-inner grayscale-[20%] hover:grayscale-0 transition-all duration-700">
        <!-- Embed Google Maps (Contoh Lokasi Indonesia) -->
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d16300624.120579563!2d108.38466605!3d-2.45030265!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4c3310154865bd%3A0x1da092f694e9959c!2sIndonesia!5e0!3m2!1sid!2sid!4v1715000000000!5m2!1sid!2sid" 
            class="w-full h-full border-0" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>

        <!-- Overlay Statistik Ringkas (Opsional - Mengambang di atas peta) -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 bg-white/90 backdrop-blur-md px-8 py-4 rounded-2xl shadow-2xl border border-white/50 flex items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                <p class="text-sm font-bold text-slate-800">500+ Titik Unit Tersebar</p>
            </div>
            <div class="h-8 w-[1px] bg-gray-200"></div>
            <p class="text-sm text-gray-600 italic">Melayani seluruh wilayah Indonesia</p>
        </div>
    </div>
</section>
</main>
<footer class="bg-(--text-black) py-16">
    <div class="container mx-auto px-4 text-center">
        <!-- Teks Informasi -->
        <div class="mb-8 space-y-1">
            <p class="text-white text-lg font-medium">
                Mari berkontribusi dengan kami. 
            </p>
            <p class="text-white text-lg font-medium">
                Untuk informasi lebih lanjut,
            </p>
            <p class="text-white text-lg font-medium mb-2">
                hubungi tim kami di
            </p>
            <a href="mailto:smartwaste@smartwaste.ac.id" class="text-[#00A36C] text-xl font-bold hover:underline transition-all">
                info@smartwaste.ac.id
            </a>
        </div>

        <!-- Ikon Sosial Media Berwarna Hijau -->
        <div class="flex justify-center gap-8 mt-10">
            <a href="#" class="group">
                <x-mdi-instagram class="w-10 h-10 text-[#00A36C] group-hover:text-white transition-colors duration-300"/>
            </a>
            <a href="#" class="group">
                <x-mdi-whatsapp class="w-10 h-10 text-[#00A36C] group-hover:text-white transition-colors duration-300"/>
            </a>
            <a href="#" class="group">
                <x-mdi-facebook class="w-10 h-10 text-[#00A36C] group-hover:text-white transition-colors duration-300"/>
            </a>
        </div>

        <!-- Copyright (Opsional tambahan) -->
        <div class="mt-12 pt-8 border-t border-gray-700/50">
            <p class="text-gray-500 text-xs tracking-widest uppercase">
                &copy; 2026 Bank Sampah Smart Waste. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

<script type="module">
$(document).ready(function() {
    const $menu = $('#menu');
    const $navBg = $('#nav-bg');
    const $iconPath = $('#icon-path');
    let isOpen = false;

    // 1. Toggle Menu Mobile
    $('#menu-btn').on('click', function() {
        // Menggunakan stop() agar animasi tidak menumpuk
        $menu.stop(true, true).slideToggle(300, function() {
            if ($(this).is(':visible')) {
                $(this).addClass('flex').removeClass('hidden');
                $(this).css('display', 'flex'); 
            } else {
                $(this).addClass('hidden').removeClass('flex');
                $(this).css('display', 'none');
            }
        });
        
        isOpen = !isOpen;
        $iconPath.attr('d', isOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16m-7 6h7');
    });

    // 2. Fix Bug: Window Resize & Reset State
    $(window).on('resize', function() {
        const width = $(window).width();

        if (width >= 768) {
            // Layar Besar: Reset ke mode desktop
            $menu.css('display', ''); 
            $menu.addClass('md:flex').removeClass('hidden flex');
            $iconPath.attr('d', 'M4 6h16M4 12h16m-7 6h7');
            isOpen = false;
        } else {
            // Layar Kecil: Pastikan menu TERTUTUP saat transisi dari besar ke kecil
            if (!isOpen) {
                $menu.addClass('hidden').removeClass('flex');
                $menu.css('display', 'none');
            }
        }
        handleScroll();
    });

    // 3. Logic Transparansi (Scroll)
    function handleScroll() {
        const scrollPos = $(window).scrollTop();
        const isDesktop = $(window).width() >= 768;

        if (isDesktop) {
            if (scrollPos > 50) {
                $navBg.addClass('md:bg-white md:shadow-md').removeClass('md:bg-transparent');
            } else {
                $navBg.addClass('md:bg-transparent').removeClass('md:bg-white md:shadow-md');
            }
        } else {
            // Mobile: Background selalu putih agar dropdown menu aman
            $navBg.addClass('bg-white shadow-sm').removeClass('bg-transparent');
        }
    }

    $(window).on('scroll', handleScroll);
    handleScroll(); // Inisialisasi awal

    // 4. Tutup menu saat link diklik (Mobile)
    $('#menu a').on('click', function() {
        if ($(window).width() < 768) {
            $menu.slideUp(300, function() {
                $(this).addClass('hidden').removeClass('flex');
            });
            $iconPath.attr('d', 'M4 6h16M4 12h16m-7 6h7');
            isOpen = false;
        }
    });

    $('.faq-question').click(function() {
        const $item = $(this).closest('.faq-item');
        const $answer = $item.find('.faq-answer');
        const $icon = $item.find('.faq-icon');

        // Menutup FAQ lain yang sedang terbuka (Optional - Mode Accordion)
        $('.faq-answer').not($answer).slideUp().addClass('hidden');
        $('.faq-icon').not($icon).removeClass('rotate-180 text-(--primary)');

        // Toggle jawaban yang diklik
        $answer.stop(true, true).slideToggle(300, function() {
            if ($(this).is(':visible')) {
                $(this).removeClass('hidden');
            } else {
                $(this).addClass('hidden');
            }
        });

        // Animasi rotasi ikon
        $icon.toggleClass('rotate-180 text-(--primary)');
    });
});
</script>
</body>