<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\JenisTiket;
use Illuminate\Support\Facades\Auth;

class JenisTiketController extends Controller
{

    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_jenis_tiket')) {
            return $response;
        }

        if ($request->ajax()) {

            $data = JenisTiket::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('jenis_tiket.edit', $row->id);
                    $deleteUrl = route('jenis_tiket.destroy', $row->id);
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

        return view('jenis_tiket.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_jenis_tiket')) {
            return $response;
        }

        return view('jenis_tiket.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_jenis_tiket')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_tikets,nama',
        ]);

        JenisTiket::create($validated);

        return redirect()->route('jenis_tiket.index')->with('success', 'JenisTiket berhasil ditambahkan.');
    }

    public function edit(JenisTiket $jenis_tiket)
    {
        if ($response = $this->checkIzin('akses_edit_jenis_tiket')) {
            return $response;
        }

        return view('jenis_tiket.edit', compact('jenis_tiket'));
    }

    public function update(Request $request, JenisTiket $jenis_tiket)
    {
        if ($response = $this->checkIzin('akses_edit_jenis_tiket')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_tikets,nama,' . $jenis_tiket->id,
        ]);

        $jenis_tiket->update($validated);

        return redirect()->route('jenis_tiket.index')->with('success', 'JenisTiket berhasil diperbarui.');
    }

    public function destroy(JenisTiket $jenis_tiket)
    {
        if ($response = $this->checkIzin('akses_hapus_jenis_tiket')) {
            return $response;
        }

        $jenis_tiket->delete();

        return redirect()->route('jenis_tiket.index')->with('success', 'JenisTiket berhasil dihapus.');
    }
}
