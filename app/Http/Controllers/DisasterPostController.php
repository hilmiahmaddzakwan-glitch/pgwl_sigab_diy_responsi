<?php

namespace App\Http\Controllers;

use App\Models\DisasterPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DisasterPostController extends Controller
{
    public function index()
    {
        $posts = DisasterPost::select('*',
            DB::raw('ST_Y(geom) as latitude'),
            DB::raw('ST_X(geom) as longitude')
        )->get();
        return view('disaster_posts.index', compact('posts'));
    }

    public function create()
    {
        return view('disaster_posts.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi inputan data
        $request->validate([
            'nama_pos'  => 'required|string|max:255',
            'jenis_pos' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // 2. Proses upload foto pos
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFoto = time() . '_' . uniqid() . '.' . $file->extension();

            // Simpan ke storage/app/public/foto_pos menggunakan disk 'public'
            $file->storeAs('foto_pos', $namaFoto, 'public');
        }

        // 3. Simpan data ke database memakai fungsi PostGIS
        DisasterPost::create([
            'nama_pos'  => $request->nama_pos,
            'jenis_pos' => $request->jenis_pos,
            'deskripsi' => $request->deskripsi,
            'foto'      => $namaFoto,
            'geom'      => DB::raw("ST_GeomFromText('POINT({$request->longitude} {$request->latitude})', 4326)")
        ]);

        return redirect('/peta')->with('success', 'Data pos baru berhasil disimpan!');
    }

    public function getPoints()
    {
        // Mengembalikan data JSON untuk dikonsumsi oleh AJAX Leaflet JavaScript
        $posts = DisasterPost::select('id', 'nama_pos', 'jenis_pos', 'deskripsi', 'foto',
            DB::raw('ST_Y(geom) as latitude'),
            DB::raw('ST_X(geom) as longitude')
        )->get();

        $posts->transform(function ($item) {
            $item->foto_url = $item->foto ? asset('storage/foto_pos/' . $item->foto) : null;
            return $item;
        });

        return response()->json($posts);
    }

    public function show(string $id) {}
    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $post = DisasterPost::findOrFail($id);

        $request->validate([
            'nama_pos'  => 'required|string|max:255',
            'jenis_pos' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama di storage disk 'public' jika ada
            if ($post->foto && Storage::disk('public')->exists('foto_pos/' . $post->foto)) {
                Storage::disk('public')->delete('foto_pos/' . $post->foto);
            }

            $file = $request->file('foto');
            $namaFoto = time() . '_' . uniqid() . '.' . $file->extension();
            $file->storeAs('foto_pos', $namaFoto, 'public');

            $post->foto = $namaFoto;
        }

        $post->nama_pos = $request->nama_pos;
        $post->jenis_pos = $request->jenis_pos;
        $post->deskripsi = $request->deskripsi;
        $post->save();

        return redirect('/peta')->with('success', 'Perubahan data pos berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $post = DisasterPost::findOrFail($id);
        if ($post->foto && Storage::disk('public')->exists('foto_pos/' . $post->foto)) {
            Storage::disk('public')->delete('foto_pos/' . $post->foto);
        }
        $post->delete();
        return redirect('/peta')->with('success', 'Data pos berhasil dihapus!');
    }
}
