<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Progress;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{

    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_progress')) {
            return $response;
        }

        if ($request->ajax()) {

            $data = Progress::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('warna', function ($row) {
                    return '<span class="badge bg-'.$row->warna.' text-light">'.$row->warna.'</span>';
                })
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('progress.edit', $row->id);
                    $deleteUrl = route('progress.destroy', $row->id);
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

        return view('progress.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_progress')) {
            return $response;
        }

        return view('progress.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_progress')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:progress,nama',
            'warna' => 'required|string|max:255|unique:progress,warna',
        ]);

        Progress::create($validated);

        return redirect()->route('progress.index')->with('success', 'Progress berhasil ditambahkan.');
    }

    public function edit(Progress $progress)
    {
        if ($response = $this->checkIzin('akses_master_edit_progress')) {
            return $response;
        }

        return view('progress.edit', compact('progress'));
    }

    public function update(Request $request, Progress $progress)
    {
        if ($response = $this->checkIzin('akses_master_edit_progress')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:progress,nama,' . $progress->id,
            'warna' => 'required|string|max:255|unique:progress,warna,' . $progress->id,
        ]);

        $progress->update($validated);

        return redirect()->route('progress.index')->with('success', 'Progress berhasil diperbarui.');
    }

    public function destroy(Progress $progress)
    {
        if ($response = $this->checkIzin('akses_master_hapus_progress')) {
            return $response;
        }

        $progress->delete();

        return redirect()->route('progress.index')->with('success', 'Progress berhasil dihapus.');
    }
}
