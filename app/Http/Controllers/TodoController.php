<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TugasRutin;
use App\Models\Tugas;

class TodoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Reset progress tugas rutin jika tanggal updated_at bukan hari ini
        $tugasRutins = TugasRutin::where('jabatan_id', $user->jabatan_id)
            ->select('id', 'judul', 'keterangan', 'progress_id', 'created_at', 'updated_at')
            ->get()
            ->map(function ($item) {
                // Reset progress ke 1 jika bukan hari ini
                if ($item->updated_at->toDateString() !== now()->toDateString()) {
                    $item->progress_id = 1;
                    $item->save();
                }
                $item->tipe = 'rutin';
                return $item;
            });

        // Ambil tugas ad-hoc:
        // - Yang dibuat hari ini
        // - ATAU yang belum selesai (progress_id < 4)
        $tugasUmum = Tugas::where('didelegasikan_ke', $user->id)
            ->where(function ($query) {
                $query->whereDate('created_at', now()->toDateString())
                    ->orWhere('progress_id', '<', 4);
            })
            ->select('id', 'judul', 'keterangan', 'progress_id', 'created_at', 'updated_at')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'ad-hoc';
                return $item;
            });

        // Gabungkan
        $semuaTugas = $tugasRutins->concat($tugasUmum)->sortByDesc('created_at')->values();

        return response()->json($semuaTugas);
    }

    // Fungsi untuk mengupdate progress
    public function updateProgress(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'tipe' => 'required|in:rutin,ad-hoc',
            'progress_id' => 'required|exists:progress,id',
        ]);

        if ($request->tipe === 'rutin') {
            $tugas = TugasRutin::findOrFail($request->id);
        } else {
            $tugas = Tugas::findOrFail($request->id);
        }

        $tugas->progress_id = $request->progress_id;
        $tugas->save();

        return redirect()->back()->with('success', 'Progress tugas berhasil di update');
    }
}
