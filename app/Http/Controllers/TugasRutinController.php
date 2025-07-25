<?php

namespace App\Http\Controllers;

use App\Models\TugasRutin;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TugasRutinController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_tugas_rutin')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = TugasRutin::with('jabatan');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('progress', function ($row) {
                    if ($row->progress) {
                        return '<span class="badge bg-' . $row->progress->warna . ' text-white">' . $row->progress->nama . '</span>';
                    }
                    return '-';
                })
                ->addColumn('jabatan_nama', fn($row) => $row->jabatan->nama ?? '-')
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('tugas_rutin.edit', $row->id);
                    $deleteUrl = route('tugas_rutin.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['aksi', 'progress'])
                ->make(true);
        }

        return view('tugas_rutin.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_tugas_rutin')) {
            return $response;
        }

        return view('tugas_rutin.create', [
            'jabatans' => Jabatan::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_tugas_rutin')) {
            return $response;
        }

        $validated = $request->validate([
            'jabatan_id'  => 'required|exists:jabatans,id',
            'judul'       => 'required|string|max:255',
            'keterangan'  => 'required|string',
        ]);

        TugasRutin::create($validated);

        return redirect()->route('tugas_rutin.index')->with('success', 'Tugas Rutin berhasil ditambahkan.');
    }

    public function edit(TugasRutin $tugas_rutin)
    {
        if ($response = $this->checkIzin('akses_edit_tugas_rutin')) {
            return $response;
        }

        return view('tugas_rutin.edit', [
            'tugas_rutin' => $tugas_rutin,
            'jabatans' => Jabatan::all(),
        ]);
    }

    public function update(Request $request, TugasRutin $tugas_rutin)
    {
        if ($response = $this->checkIzin('akses_edit_tugas_rutin')) {
            return $response;
        }

        $validated = $request->validate([
            'jabatan_id'  => 'required|exists:jabatans,id',
            'judul'       => 'required|string|max:255',
            'keterangan'  => 'required|string',
        ]);

        $tugas_rutin->update($validated);

        return redirect()->route('tugas_rutin.index')->with('success', 'Tugas Rutin berhasil diperbarui.');
    }

    public function destroy(TugasRutin $tugas_rutin)
    {
        if ($response = $this->checkIzin('akses_hapus_tugas_rutin')) {
            return $response;
        }

        $tugas_rutin->delete();

        return redirect()->route('tugas_rutin.index')->with('success', 'TugasRutin berhasil dihapus.');
    }
}
