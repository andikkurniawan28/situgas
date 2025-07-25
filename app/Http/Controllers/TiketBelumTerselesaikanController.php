<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tiket;

class TiketBelumTerselesaikanController extends Controller
{
    // Ambil tiket yang belum selesai (progress_id < 4)
    public function index()
    {
        $user = Auth::user();

        $tiketBelumSelesai = Tiket::with('klien:id,nama') // Load relasi klien (ambil hanya id & nama)
            ->where('didelegasikan_ke', $user->id)
            ->where('progress_id', '<', 4)
            ->select('id', 'judul', 'keterangan', 'progress_id', 'klien_id', 'created_at', 'updated_at')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'tiket';
                $item->klien_nama = $item->klien->nama ?? '-'; // Tambahkan properti klien_nama
                return $item;
            });

        return response()->json($tiketBelumSelesai);
    }

    // Update progress tiket
    public function updateProgress(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'progress_id' => 'required|exists:progress,id',
        ]);

        $tiket = Tiket::where('id', $request->id)
            ->where('didelegasikan_ke', Auth::id())
            ->firstOrFail();

        $tiket->progress_id = $request->progress_id;
        $tiket->save();

        return redirect()->back()->with('success', 'Progress tiket berhasil diupdate.');
    }
}
