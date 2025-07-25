<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\User;
use App\Models\Progress;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_tugas')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Tugas::with(['progress', 'delegasi', 'pembuat']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('progress', function ($row) {
                    if ($row->progress) {
                        return '<span class="badge bg-' . $row->progress->warna . ' text-white">' . $row->progress->nama . '</span>';
                    }
                    return '-';
                })
                ->addColumn('pembuat', fn($row) => $row->pembuat->nama ?? '-')
                ->addColumn('delegasi', fn($row) => $row->delegasi->nama ?? '-')
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('tugas.edit', $row->id);
                    $showUrl = route('tugas.show', $row->id);
                    $deleteUrl = route('tugas.destroy', $row->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                    <a href="' . $showUrl . '" class="btn btn-sm btn-info">Detail</a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus tugas ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                ';
                })
                ->rawColumns(['aksi', 'progress'])
                ->make(true);
        }

        return view('tugas.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_tugas')) {
            return $response;
        }

        return view('tugas.create', [
            'users' => User::all(),
            'progresses' => Progress::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_tugas')) {
            return $response;
        }

        $request->request->add(['dibuat_oleh' => Auth()->user()->id]);

        $request->validate([
            'didelegasikan_ke' => 'required|exists:users,id',
            'dibuat_oleh' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'gambar1' => 'nullable|image|max:2048',
            'gambar2' => 'nullable|image|max:2048',
            'gambar3' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['gambar1', 'gambar2', 'gambar3']);

        // Upload gambar
        foreach (['gambar1', 'gambar2', 'gambar3'] as $gambar) {
            if ($request->hasFile($gambar)) {
                $data[$gambar] = $request->file($gambar)->store('tugas', 'public');
            }
        }

        Tugas::create($data);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function show(Tugas $tugas)
    {
        if ($response = $this->checkIzin('akses_detail_tugas')) {
            return $response;
        }
        $tugas->load(['delegasi', 'pembuat', 'progress']);
        return view('tugas.show', compact('tugas'));
    }

    public function edit(Tugas $tugas)
    {
        if ($response = $this->checkIzin('akses_edit_tugas')) {
            return $response;
        }

        return view('tugas.edit', [
            'tugas' => $tugas,
            'users' => User::all(),
            'progresses' => Progress::all(),
        ]);
    }

    public function update(Request $request, Tugas $tugas)
    {
        if ($response = $this->checkIzin('akses_edit_tugas')) {
            return $response;
        }

        $request->validate([
            'didelegasikan_ke' => 'required|exists:users,id',
            // 'dibuat_oleh' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'gambar1' => 'nullable|image|max:2048',
            'gambar2' => 'nullable|image|max:2048',
            'gambar3' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['gambar1', 'gambar2', 'gambar3']);

        foreach (['gambar1', 'gambar2', 'gambar3'] as $gambar) {
            if ($request->hasFile($gambar)) {
                $data[$gambar] = $request->file($gambar)->store('tugas', 'public');
            }
        }

        $tugas->update($data);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroy(Tugas $tugas)
    {
        if ($response = $this->checkIzin('akses_hapus_tugas')) {
            return $response;
        }
        $tugas->delete();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus');
    }
}
