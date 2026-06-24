<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DisasterPostController;
use Illuminate\Support\Facades\Route;
use App\Models\DisasterHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\DisasterPost;
use App\Models\User;

// Halaman Utama Sebelum Login
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $totalPosko = DisasterPost::count();

    $totalBencana = DisasterHistory::count();

    $totalPengguna = User::count();

    return view('dashboard', compact(
        'totalPosko',
        'totalBencana',
        'totalPengguna'
    ));

})->middleware(['auth', 'verified'])->name('dashboard');

// Rute yang Membutuhkan Autentikasi (Login)
Route::middleware('auth')->group(function () {
    // Manajemen Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Tampilan Peta Leaflet
    Route::get('/peta', function () {
        return view('peta');
    });

    // Rute API internal untuk mengambil data spasial ke Leaflet
    Route::get('/api/disaster-posts', [DisasterPostController::class, 'getPoints'])->name('api.disaster-posts');

    // API: Mengambil data Polygon dan mengonversinya ke format Teks (WKT) agar dibaca Leaflet
    Route::get('/api/disaster-histories', function() {
        $histories = DisasterHistory::select('id', 'nama_bencana', 'jenis_bencana', 'tanggal_kejadian', 'keterangan', 'foto',
            DB::raw('ST_AsText(geom) as geometry_wkt')
        )->get();

        $histories->transform(function ($item) {
            $item->foto_url = $item->foto ? asset('storage/foto_bencana/' . $item->foto) : null;
            return $item;
        });

        return response()->json($histories);
    })->name('api.disaster-histories');

// STORE: Menyimpan Data Area Baru berupa POLYGON dengan pembersihan spasi hidden
    Route::post('/disaster-histories', function(Request $request) {
        $request->validate([
            'nama_bencana' => 'required|string|max:255',
            'jenis_bencana' => 'required|string|max:255',
            'tanggal_kejadian' => 'required|date',
            'coordinates' => 'required|string',
            'foto' => 'nullable|image|max:2048'
        ]);

        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cleanedName = str_replace(' ', '', $file->getClientOriginalName());
            $namaFoto = time() . '_' . $cleanedName;
            $file->storeAs('foto_bencana', $namaFoto, 'public');
        }

        // Membersihkan karakter spasi tak terlihat (non-breaking space) sebelum di-decode
        $cleanCoordinates = preg_replace('/[\x00-\x1F\x7F-\x9F\xA0]/u', ' ', $request->coordinates);
        $pointsArray = json_decode(trim($cleanCoordinates), true);

        if (!is_array($pointsArray) || count($pointsArray) < 3) {
            return redirect('/peta')->withErrors(['coordinates' => 'Gagal memproses geometri. Pastikan titik area minimal 3 titik.']);
        }

        $wktPoints = [];
        foreach ($pointsArray as $point) {
            $lat = (float) $point[0];
            $lng = (float) $point[1];
            $wktPoints[] = $lng . ' ' . $lat;
        }

        // Aturan PostGIS: kunci poligon ke titik awal
        $firstLat = (float) $pointsArray[0][0];
        $firstLng = (float) $pointsArray[0][1];
        $wktPoints[] = $firstLng . ' ' . $firstLat;

        $wktString = "POLYGON((" . implode(',', $wktPoints) . "))";

        // Menggunakan updateOrInsert atau create langsung setelah $fillable dibuka
        DisasterHistory::create([
            'nama_bencana' => $request->nama_bencana,
            'jenis_bencana' => $request->jenis_bencana,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'keterangan' => $request->keterangan,
            'foto' => $namaFoto,
            'geom' => DB::raw("ST_GeomFromText('{$wktString}', 4326)")
        ]);

        return redirect('/peta')->with('success', 'Data riwayat area bencana berhasil disimpan!');
    })->name('disaster-histories.store');

    // UPDATE: Memperbarui Atribut (Nama, Jenis, Tanggal, Keterangan, Foto) Tanpa Mengubah Geometri
    Route::put('/disaster-histories/{id}', function(Request $request, $id) {
        $dh = DisasterHistory::findOrFail($id);

        $request->validate([
            'nama_bencana' => 'required|string|max:255',
            'jenis_bencana' => 'required|string|max:255',
            'tanggal_kejadian' => 'required|date',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($dh->foto && Storage::disk('public')->exists('foto_bencana/' . $dh->foto)) {
                Storage::disk('public')->delete('foto_bencana/' . $dh->foto);
            }
            $file = $request->file('foto');
            $cleanedName = str_replace(' ', '', $file->getClientOriginalName());
            $namaFoto = time() . '_' . $cleanedName;
            $file->storeAs('foto_bencana', $namaFoto, 'public');
            $dh->foto = $namaFoto;
        }

        $dh->nama_bencana = $request->nama_bencana;
        $dh->jenis_bencana = $request->jenis_bencana;
        $dh->tanggal_kejadian = $request->tanggal_kejadian;
        $dh->keterangan = $request->keterangan;
        $dh->save();

        return redirect('/peta')->with('success', 'Data riwayat area bencana berhasil diperbarui!');
    })->name('disaster-histories.update');

    // DESTROY: Menghapus Data Spasial Area Bencana
    Route::delete('/disaster-histories/{id}', function($id) {
        $dh = DisasterHistory::findOrFail($id);
        if ($dh->foto && Storage::disk('public')->exists('foto_bencana/' . $dh->foto)) {
            Storage::disk('public')->delete('foto_bencana/' . $dh->foto);
        }
        $dh->delete();
        return redirect('/peta')->with('success', 'Data riwayat area bencana berhasil dihapus!');
    })->name('disaster-histories.destroy');

    // Rute Tentang Aplikasi
    Route::get('/tentang', function () {
        return view('tentang');
    })->name('tentang');
});

// Rute Resource untuk CRUD Pos Kebencanaan
Route::resource('disaster-posts', DisasterPostController::class)->middleware('auth');

// Rute Autentikasi Bawaan Laravel Breeze
require __DIR__.'/auth.php';
