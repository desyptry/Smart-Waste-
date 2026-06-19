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

    <!-- MENU OFFICER -->
    <ul class="flex flex-col gap-4 flex-grow">

        <!-- DASHBOARD -->
        <li>
            <a href="/officer/dashboard" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Dashboard</span>
                <span class="link-icon hidden">
                    <x-mdi-view-dashboard class="w-6 h-6"/>
                </span>
            </a>
        </li>


        <!-- JADWAL -->
        <li>
            <a href="/officer/jadwal" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Jadwal</span>
                <span class="link-icon hidden">
                    <x-mdi-calendar class="w-6 h-6"/>
                </span>
            </a>
        </li>

        <!-- MONITORING -->
        <li>
            <a href="/officer/monitoring" class="sidebar-link flex justify-center items-center w-full py-4 bg-white text-slate-900 font-black rounded-xl shadow-sm hover:bg-gray-100 transition-all text-lg overflow-hidden whitespace-nowrap">
                <span class="link-text">Monitoring dan Laporan</span>
                <span class="link-icon hidden">
                    <x-mdi-chart-line class="w-6 h-6"/>
                </span>
            </a>
        </li>


    </ul>

    <!-- LOGOUT -->
    <div class="mt-auto pt-6 border-t border-slate-700">
        <form action="{{ route('logout') }}" method="POST">
    @csrf
        
            <button type="submit" class="flex items-center justify-center gap-3 w-full py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-all shadow-lg overflow-hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="link-text">Logout</span>
            </button>
        </form>
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