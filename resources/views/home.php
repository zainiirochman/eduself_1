<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSelf</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <header class="bg-blue-500 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo EduSelf" class="h-10 w-10 mr-3 rounded-full">
                <h1 class="text-2xl font-semibold">EduSelf</h1>
            </div>
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
            <h2 class="text-xl font-semibold mb-4">Selamat Datang di EduSelf</h2>
            <p>“EduSelf” yang berasal dari dua kata yaitu “Edu” yang berarti Education atau edukasi dan “Self” yang berarti diri sendiri atau mandiri. Dengan EduSelf pengguna dapat mendapatkan informasi buku buku di perpustakaan, mulai dari kategori buku, peminjaman buku, pengembalian buku, dan lain sebagainya. Eduself menawarkan aplikasi dengan antar muka yang ramah pengguna, ringan, dan menarik untuk digunakan. Aplikasi ini membantu pengguna mengembangkan diri melalui pendidikan mandiri. Jadi bukan sekadar sistem informasi perpustakaan, tapi juga media untuk membangun self-growth melalui literasi. EduSelf — Akses ilmu, kembangkan dirimu!!!</p>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2025 EduSelf. All rights reserved.</p>
    </footer>

</body>
</html>