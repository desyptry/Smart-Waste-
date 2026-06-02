<!DOCTYPE html>
<html>
<head>
    <title>Officer</title>

    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="flex">

    @include('officer.layout.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')

</body>
</html>