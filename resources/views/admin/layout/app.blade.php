<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex">

    @include('admin.layout.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')

</body>
</html>