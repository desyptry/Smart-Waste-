<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-300">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('admin.layout.sidebar')

    {{-- Main --}}
    <div class="flex-1">

        {{-- Header --}}
        <div class="bg-green-500 text-white px-6 py-3 font-semibold">
            @yield('title')
        </div>

        {{-- Content --}}
        <div class="p-6">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>