<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use App\Models\LevelKlien;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KlienController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_klien')) {
            return $response;
        }

        if ($request->ajax()) {
             $data = Klien::with('level_klien');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('level_nama', fn($row) => $row->level_klien->nama ?? '-')
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('klien.edit', $row->id);
                    $deleteUrl = route('klien.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('klien.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_klien')) {
            return $response;
        }

        return view('klien.create', [
            'level_kliens' => LevelKlien::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_klien')) {
            return $response;
        }

        $validated = $request->validate([
            'level_klien_id' => 'required|exists:level_kliens,id',
            'nama' => 'required|string|max:255|unique:kliens,nama',
            'perusahaan' => 'nullable|string|max:255',
            'bidang_usaha' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        Klien::create($validated);

        return redirect()->route('klien.index')->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit(Klien $klien)
    {
        if ($response = $this->checkIzin('akses_master_edit_klien')) {
            return $response;
        }

        return view('klien.edit', [
            'klien' => $klien,
            'level_kliens' => LevelKlien::all(),
        ]);
    }

    public function update(Request $request, Klien $klien)
    {
        if ($response = $this->checkIzin('akses_master_edit_klien')) {
            return $response;
        }

        $validated = $request->validate([
            'level_klien_id' => 'required|exists:level_kliens,id',
            'nama' => 'required|string|max:255|unique:kliens,nama,' . $klien->id,
            'perusahaan' => 'nullable|string|max:255',
            'bidang_usaha' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        $klien->update($validated);

        return redirect()->route('klien.index')->with('success', 'Klien berhasil diperbarui.');
    }

    public function destroy(Klien $klien)
    {
        if ($response = $this->checkIzin('akses_master_hapus_klien')) {
            return $response;
        }

        $klien->delete();

        return redirect()->route('klien.index')->with('success', 'Klien berhasil dihapus.');
    }
}
