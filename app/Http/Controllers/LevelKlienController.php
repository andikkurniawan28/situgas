<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\LevelKlien;
use Illuminate\Support\Facades\Auth;

class LevelKlienController extends Controller
{

    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_level_klien')) {
            return $response;
        }

        if ($request->ajax()) {

            $data = LevelKlien::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('warna', function ($row) {
                    return '<span class="badge bg-'.$row->warna.' text-light">'.$row->warna.'</span>';
                })
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('level_klien.edit', $row->id);
                    $deleteUrl = route('level_klien.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['aksi', 'warna'])
                ->make(true);
        }

        return view('level_klien.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_level_klien')) {
            return $response;
        }

        return view('level_klien.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_level_klien')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:level_kliens,nama',
            'warna' => 'required|string|max:255|unique:level_kliens,warna',
        ]);

        LevelKlien::create($validated);

        return redirect()->route('level_klien.index')->with('success', 'LevelKlien berhasil ditambahkan.');
    }

    public function edit(LevelKlien $level_klien)
    {
        if ($response = $this->checkIzin('akses_master_edit_level_klien')) {
            return $response;
        }

        return view('level_klien.edit', compact('level_klien'));
    }

    public function update(Request $request, LevelKlien $level_klien)
    {
        if ($response = $this->checkIzin('akses_master_edit_level_klien')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:level_kliens,nama,' . $level_klien->id,
            'warna' => 'required|string|max:255|unique:level_kliens,warna,' . $level_klien->id,
        ]);

        $level_klien->update($validated);

        return redirect()->route('level_klien.index')->with('success', 'LevelKlien berhasil diperbarui.');
    }

    public function destroy(LevelKlien $level_klien)
    {
        if ($response = $this->checkIzin('akses_master_hapus_level_klien')) {
            return $response;
        }

        $level_klien->delete();

        return redirect()->route('level_klien.index')->with('success', 'LevelKlien berhasil dihapus.');
    }
}
