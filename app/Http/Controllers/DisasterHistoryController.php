<?php

namespace App\Http\Controllers;

use App\Models\DisasterHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisasterHistoryController extends Controller
{
    // API endpoint untuk mengambil semua polygon area bencana
    public function apiIndex()
    {
        return response()->json(DisasterHistory::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bencana' => 'required|string',
            'jenis_bencana' => 'required|string',
            'tanggal_kejadian' => 'required|date',
            'coordinates' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $fileName = null;
        if ($request->hasFile('foto')) {
            // Menghapus spasi dari nama file asli sesuai perintah Anda
            $originalName = str_replace(' ', '', $request->file('foto')->getClientOriginalName());
            $fileName = time() . '_' . $originalName;
            $request->file('foto')->storeAs('foto_bencana', $fileName, 'public');
        }

        DisasterHistory::create([
            'nama_bencana' => $request->nama_bencana,
            'jenis_bencana' => $request->jenis_bencana,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'keterangan' => $request->keterangan,
            'coordinates' => $request->coordinates,
            'foto' => $fileName,
        ]);

        return redirect()->back()->with('success', 'Riwayat Area Bencana Berhasil Ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $history = DisasterHistory::findOrFail($id);

        $request->validate([
            'nama_bencana' => 'required|string',
            'jenis_bencana' => 'required|string',
            'tanggal_kejadian' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($history->foto) {
                Storage::disk('public')->delete('foto_bencana/' . $history->foto);
            }
            $originalName = str_replace(' ', '', $request->file('foto')->getClientOriginalName());
            $fileName = time() . '_' . $originalName;
            $request->file('foto')->storeAs('foto_bencana', $fileName, 'public');
            $history->foto = $fileName;
        }

        $history->update([
            'nama_bencana' => $request->nama_bencana,
            'jenis_bencana' => $request->jenis_bencana,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Riwayat Area Bencana Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $history = DisasterHistory::findOrFail($id);
        if ($history->foto) {
            Storage::disk('public')->delete('foto_bencana/' . $history->foto);
        }
        $history->delete();

        return redirect()->back()->with('success', 'Riwayat Area Bencana Berhasil Dihapus!');
    }
}
