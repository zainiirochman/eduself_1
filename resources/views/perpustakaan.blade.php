<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-blue-500 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Perpustakaan Digital</h1>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="/" class="hover:text-gray-200">Home</a></li>
                    <li><a href="/tentang-kami" class="hover:text-gray-200">Tentang Kami</a></li>
                    <li><a href="/perpustakaan" class="hover:text-gray-200">Perpustakaan</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-8">
        <div class="bg-white shadow-md rounded px-8 py-6">
            <h2 class="text-xl font-semibold mb-4">Daftar Buku</h2>
            <!-- Kolom Pencarian -->
            <form method="GET" action="{{ url('/perpustakaan') }}" class="mb-6 flex items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul buku..."
                    class="border rounded px-4 py-2 w-full max-w-xs mr-2"
                >
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
            </form>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Judul</th>
                        <th class="py-2 px-4 border-b">Penulis</th>
                        <th class="py-2 px-4 border-b">Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $book->title }}</td>
                        <td class="py-2 px-4 border-b">{{ $book->author }}</td>
                        <td class="py-2 px-4 border-b">{{ $book->year }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2024 Perpustakaan Digital. All rights reserved.</p>
    </footer>
</body>
</html>