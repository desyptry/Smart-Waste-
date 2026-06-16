<!-- Sidebar Container -->
<div id="main-sidebar" class="w-72 bg-[#2D333D] text-white min-h-screen flex flex-col p-6 shadow-xl transition-all duration-300 relative">
    
    <!-- Toggle -->
    <button id="toggle-sidebar" class="absolute -right-3 top-10 bg-[#69C3C1] p-1 rounded-full text-white shadow-md">
        <svg id="toggle-icon" class="h-5 w-5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
        </svg>
    </button>

    <!-- Logo -->
    <div class="flex justify-center mb-10">
        <img src="{{ asset('images/logo.png') }}" id="sidebar-logo" class="w-40 transition-all duration-300">
    </div>

    <!-- MENU -->
    <ul class="flex flex-col gap-4 flex-grow">

        <!-- Dashboard -->
        <li>
            <a href="/admin/dashboard" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Dashboard</span>
                <span class="link-icon hidden">
                    <x-mdi-view-dashboard class="w-6 h-6"/>
                </span>
            </a>
        </li>

        <!-- User -->
        <li>
            <a href="{{ route('admin.user.index') }}" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Kelola User</span>
                <span class="link-icon hidden">
                <x-mdi-account-group class="w-6 h-6"/>
        </span>
    </a>
</li>
        <li>
            <a href="{{route('admin.kategori.index')}}" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Kelola Kategori</span>
                <span class="link-icon hidden">
                    <x-mdi-account-group class="w-6 h-6"/>
                </span>
            </a>
        </li>

        <!-- Posko -->
        <li>
            <a href="/admin/posko" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Data Posko</span>
                <span class="link-icon hidden">
                    <x-mdi-office-building class="w-6 h-6"/>
                </span>
            </a>
        </li>


        <!-- Laporan -->
        <li>
            <a href="/admin/laporan" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Laporan</span>
                <span class="link-icon hidden">
                    <x-mdi-chart-bar class="w-6 h-6"/>
                </span>
            </a>
        </li>

        <!-- Konfigurasi -->
        <li>
            <a href="/admin/konfigurasi" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Konfigurasi</span>
                <span class="link-icon hidden">
                    <x-mdi-cog class="w-6 h-6"/>
                </span>
            </a>
        </li>

    </ul>

    <!-- Logout -->
    <div class="mt-auto pt-4 border-t border-gray-600">
        <button class="w-full py-3 bg-red-500 rounded-xl font-bold">
            <span class="link-text">Logout</span>
        </button>
    </div>

</div>

{{-- SCRIPT --}}
@push('scripts')
<script>
$(document).ready(function() {

    let isMinimized = false;

    $('#toggle-sidebar').click(function() {
        isMinimized = !isMinimized;

        if (isMinimized) {

            $('#main-sidebar').removeClass('w-72').addClass('w-24');
            $('#sidebar-logo').addClass('scale-50 opacity-0');

            $('.link-text').fadeOut(100);

            setTimeout(() => {
                $('.link-icon').fadeIn().removeClass('hidden');
            }, 200);

            $('#toggle-icon').addClass('rotate-180');

        } else {

            $('#main-sidebar').removeClass('w-24').addClass('w-72');
            $('#sidebar-logo').removeClass('scale-50 opacity-0');

            $('.link-icon').fadeOut(100);

            setTimeout(() => {
                $('.link-text').fadeIn().removeClass('hidden');
            }, 200);

            $('#toggle-icon').removeClass('rotate-180');
        }
    });

});
</script>
@endpush