<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- CDN Tailwind (untuk cepat) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <h1 class="text-xl font-bold">Admin Dashboard</h1>
    </nav>

    <!-- Container -->
    <div class="p-6">

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Selamat Datang</h2>
            <p class="text-gray-600 mb-4">
                Ini adalah halaman admin sederhana menggunakan Tailwind CSS.
            </p>

            <!-- Button -->
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Klik Saya
            </button>
        </div>

        <!-- Table sederhana -->
        <div class="mt-6 bg-white p-6 rounded-2xl shadow-md">
            <h2 class="text-lg font-semibold mb-4">Data</h2>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">No</th>
                        <th class="p-2">Nama</th>
                        <th class="p-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-2">1</td>
                        <td class="p-2">Desy</td>
                        <td class="p-2 text-green-500">Aktif</td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">2</td>
                        <td class="p-2">User 2</td>
                        <td class="p-2 text-red-500">Nonaktif</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>