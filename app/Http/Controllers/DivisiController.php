<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Divisi;
use Illuminate\Support\Facades\Auth;

class DivisiController extends Controller
{

    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_divisi')) {
            return $response;
        }

        if ($request->ajax()) {

            $data = Divisi::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('divisi.edit', $row->id);
                    $deleteUrl = route('divisi.destroy', $row->id);
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

        return view('divisi.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_divisi')) {
            return $response;
        }

        return view('divisi.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_divisi')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:divisis,nama',
        ]);

        Divisi::create($validated);

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function edit(Divisi $divisi)
    {
        if ($response = $this->checkIzin('akses_master_edit_divisi')) {
            return $response;
        }

        return view('divisi.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        if ($response = $this->checkIzin('akses_master_edit_divisi')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:divisis,nama,' . $divisi->id,
        ]);

        $divisi->update($validated);

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Divisi $divisi)
    {
        if ($response = $this->checkIzin('akses_master_hapus_divisi')) {
            return $response;
        }

        $divisi->delete();

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil dihapus.');
    }
}
