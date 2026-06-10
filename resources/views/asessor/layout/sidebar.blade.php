<!-- Sidebar Container -->
<div id="main-sidebar" class="w-72 bg-[#2D333D] text-white min-h-screen flex flex-col p-6 shadow-xl transition-all duration-300 relative">
    
    <!-- Toggle Button (Minimize/Expand) -->
    <button id="toggle-sidebar" class="absolute -right-3 top-10 bg-[#69C3C1] p-1 rounded-full text-white shadow-md hover:scale-110 transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg" id="toggle-icon" class="h-5 w-5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
        </svg>
    </button>

    <!-- Logo Section -->
    <div class="flex flex-col items-center mb-10 sidebar-header">
        <img src="{{ asset('images/logo.png') }}" id="sidebar-logo" alt="Logo" class="w-48 object-contain transition-all duration-300">
    </div>

    <!-- Navigation Menu -->
    <ul class="flex flex-col gap-4 flex-grow">
        <li>
            <a href="{{ route('user.dashboard') }}" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Dashboard</span>
                <span class="link-icon hidden"><x-mdi-view-dashboard class="w-6 h-6"/></span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.katalog-sampah') }}" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Katalog Sampah</span>
                <span class="link-icon hidden"><x-mdi-archive-outline class="w-6 h-6"/></span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.jadwal') }}" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Jadwal</span>
                <span class="link-icon hidden"><x-mdi-calendar-clock class="w-6 h-6"/></span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.riwayat') }}" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Riwayat Transaksi</span>
                <span class="link-icon hidden"><x-mdi-history class="w-6 h-6"/></span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.pencairan') }}" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Penarikan</span>
                <span class="link-icon hidden"><x-mdi-cash-fast class="w-6 h-6"/></span>
            </a>
        </li>
    </ul>

    <!-- Footer Sidebar: Logout -->
    <div class="mt-auto pt-6 border-t border-slate-700">
        <form method="POST" action="">
            @csrf
            <button type="submit" class="flex items-center justify-center gap-3 w-full py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-all shadow-lg overflow-hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="link-text">Logout</span>
            </button>
        </form>
    </div>

    <script type="module">
        $(document).ready(function() {
    let isMinimized = false;

    $('#toggle-sidebar').on('click', function() {
        isMinimized = !isMinimized;

        if (isMinimized) {
            // Animasi Mengecil
            $('#main-sidebar').removeClass('w-72').addClass('w-24');
            $('#sidebar-logo').addClass('scale-50 opacity-0');
            $('.link-text').fadeOut(100); // Sembunyikan teks
            
            // Tampilkan ikon jika Anda menambahkan elemen link-icon
            setTimeout(() => {
                $('.link-icon').fadeIn().removeClass('hidden');
            }, 200);

            // Putar icon toggle
            $('#toggle-icon').addClass('rotate-180');
        } else {
            // Animasi Membesar
            $('#main-sidebar').removeClass('w-24').addClass('w-72');
            $('#sidebar-logo').removeClass('scale-50 opacity-0');
            $('.link-icon').fadeOut(100);
            
            setTimeout(() => {
                $('.link-text').fadeIn().removeClass('hidden');
            }, 200);

            // Kembalikan icon toggle
            $('#toggle-icon').removeClass('rotate-180');
        }
    });
});
    </script>
</div>