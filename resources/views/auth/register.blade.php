<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Smart Waste</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F9FC] min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-5xl bg-white rounded-[3rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-gray-100">
        
        <div class="w-full md:w-1/2 p-8 md:p-14 flex flex-col justify-center">
            <div class="mb-6">
                <h1 class="text-4xl font-black text-slate-800 tracking-tight">Mulai Sekarang</h1>
                <p class="text-gray-500 mt-2 font-medium">Lengkapi data diri Anda untuk bergabung</p>
            </div>

            <form id="register-form" action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}"
                           class="input-custom w-full px-6 py-4 bg-[#F8FAFC] border-2 border-transparent rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 @error('name') border-red-500 @enderror">
                    @error('name') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Alamat Email</label>
                    <input type="email" name="email" required placeholder="nama@email.com" value="{{ old('email') }}"
                           class="input-custom w-full px-6 py-4 bg-[#F8FAFC] border-2 border-transparent rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Alamat Lengkap</label>
                    <textarea name="address" required rows="2" placeholder="Jl. Teratai No. 123..." 
                              class="input-custom w-full px-6 py-4 bg-[#F8FAFC] border-2 border-transparent rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 resize-none @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                    @error('address') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="••••••••" 
                               class="input-custom w-full px-6 py-4 bg-[#F8FAFC] border-2 border-transparent rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300 @error('password') border-red-500 @enderror">
                        <button type="button" id="toggle-password" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#69C3C1]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••" 
                           class="input-custom w-full px-6 py-4 bg-[#F8FAFC] border-2 border-transparent rounded-2xl font-bold text-slate-700 outline-none transition-all duration-300">
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full py-4 bg-[#69C3C1] hover:bg-[#58A8A6] text-white font-black text-lg rounded-2xl shadow-xl shadow-cyan-100 transform hover:-translate-y-1 transition-all duration-300 active:scale-95">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-gray-500 font-semibold text-sm">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-[#69C3C1] font-black hover:underline underline-offset-4 ml-1">Masuk</a>
            </p>
        </div>

        <div class="hidden md:flex w-1/2 bg-[#2D333D] items-center justify-center p-12 relative">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#69C3C1 1px, transparent 1px); background-size: 20px 20px;"></div>
            <div class="relative z-10 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Smart Waste Logo" class="w-64 mx-auto mb-8 transform hover:scale-105 transition-transform duration-500">
            </div>
        </div>
    </div>

    <script type="module">
        $(document).ready(function() {
            $('input, textarea').on('focus', function() {
                $(this).closest('.space-y-1').find('label').addClass('text-[#69C3C1]');
            }).on('blur', function() {
                $(this).closest('.space-y-1').find('label').removeClass('text-[#69C3C1]');
            });

            $('#toggle-password').on('click', function() {
                const passInput = $('#password');
                const isPassword = passInput.attr('type') === 'password';
                passInput.attr('type', isPassword ? 'text' : 'password');
                $(this).toggleClass('text-[#69C3C1]');
            });

            $('#register-form').on('submit', function() {
                const $btn = $(this).find('button[type="submit"]');
                $btn.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');
                $btn.html('<svg class="animate-spin h-6 w-6 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>');
            });
        });
    </script>
</body>
</html>
