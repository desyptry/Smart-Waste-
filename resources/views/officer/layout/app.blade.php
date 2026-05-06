<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Petugas</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-300">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('officer.layout.sidebar')

    {{-- Main --}}
    <div class="flex-1">

        {{-- Header --}}
        <div class="bg-gray-800 text-white px-6 py-3 font-semibold">
            @yield('title', 'Dashboard Petugas')
        </div>

        {{-- Content --}}
        <div class="p-6">
            @yield('content')
        </div>

    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Tempat script tambahan -->
@stack('scripts')

</body>
</html>