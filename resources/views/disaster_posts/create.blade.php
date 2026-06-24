<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Koordinat Pos Bencana</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Tambah Titik Pos Kebencanaan</h2>

        <form action="{{ url('/disaster-posts') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Pos</label>
                <input type="text" name="nama_pos" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Pos</label>
                <input type="text" name="jenis_pos" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Latitude</label>
                <input type="text" name="latitude" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="-7.7956">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Longitude</label>
                <input type="text" name="longitude" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="110.3695">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Foto Pos</label>
                <input type="file" name="foto" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <a href="{{ url('/peta') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan Data</button>
            </div>
        </form>
    </div>

</body>
</html>
