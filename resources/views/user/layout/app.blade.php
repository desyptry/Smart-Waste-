<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        @yield('page-title')
    </title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body class="bg-(--primary-bg)">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('user.layout.sidebar')

    {{-- Main --}}
    <div class="flex-1">

        {{-- Header --}}
        <!-- <div class="bg-(--primary) text-white px-6 py-3 font-semibold"> -->
            <!-- @yield('title') -->
        <!-- </div> -->

        {{-- Content --}}
        <div class="p-6">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>