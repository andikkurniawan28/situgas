<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_jabatan')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Jabatan::with('divisi');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('divisi_nama', fn($row) => $row->divisi->nama ?? '-')
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('jabatan.edit', $row->id);
                    $deleteUrl = route('jabatan.destroy', $row->id);
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

        return view('jabatan.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_jabatan')) {
            return $response;
        }

        return view('jabatan.create', [
            'divisis' => Divisi::all(),
            'akses' => Jabatan::semuaAkses(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_jabatan')) {
            return $response;
        }

        $rules = [
            'nama' => 'required|string|max:255|unique:jabatans,nama',
            'divisi_id' => 'required|exists:divisis,id',
        ];

        foreach (Jabatan::semuaAkses() as $akses) {
            $rules[$akses] = 'nullable|boolean';
        }

        $validated = $request->validate($rules);

        $jabatanData = collect($validated)
            ->only(array_merge(['nama', 'divisi_id'], Jabatan::semuaAkses()))
            ->toArray();

        foreach (Jabatan::semuaAkses() as $akses) {
            $jabatanData[$akses] = $request->has($akses) ? 1 : 0;
        }

        Jabatan::create($jabatanData);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit(Jabatan $jabatan)
    {
        if ($response = $this->checkIzin('akses_master_edit_jabatan')) {
            return $response;
        }

        return view('jabatan.edit', [
            'jabatan' => $jabatan,
            'divisis' => Divisi::all(),
            'akses' => Jabatan::semuaAkses(),
        ]);
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        if ($response = $this->checkIzin('akses_master_edit_jabatan')) {
            return $response;
        }

        $rules = [
            'nama' => 'required|string|max:255|unique:jabatans,nama,' . $jabatan->id,
            'divisi_id' => 'required|exists:divisis,id',
        ];

        // Validasi akses sebagai boolean
        foreach (Jabatan::semuaAkses() as $akses) {
            $rules[$akses] = 'nullable|boolean';
        }

        $validated = $request->validate($rules);

        // Siapkan data yang akan diupdate
        $jabatanData = [
            'nama' => $validated['nama'],
            'divisi_id' => $validated['divisi_id'],
        ];

        foreach (Jabatan::semuaAkses() as $akses) {
            $jabatanData[$akses] = $request->has($akses) ? 1 : 0;
        }

        $jabatan->update($jabatanData);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui.');
    }


    public function destroy(Jabatan $jabatan)
    {
        if ($response = $this->checkIzin('akses_master_hapus_jabatan')) {
            return $response;
        }

        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}
