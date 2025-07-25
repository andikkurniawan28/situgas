<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\JenisAkun;
use Illuminate\Support\Facades\Auth;

class JenisAkunController extends Controller
{

    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_jenis_akun')) {
            return $response;
        }

        if ($request->ajax()) {

            $data = JenisAkun::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('jenis_akun.edit', $row->id);
                    $deleteUrl = route('jenis_akun.destroy', $row->id);
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

        return view('jenis_akun.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_jenis_akun')) {
            return $response;
        }

        return view('jenis_akun.create');
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_jenis_akun')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_akuns,nama',
        ]);

        JenisAkun::create($validated);

        return redirect()->route('jenis_akun.index')->with('success', 'JenisAkun berhasil ditambahkan.');
    }

    public function edit(JenisAkun $jenis_akun)
    {
        if ($response = $this->checkIzin('akses_edit_jenis_akun')) {
            return $response;
        }

        return view('jenis_akun.edit', compact('jenis_akun'));
    }

    public function update(Request $request, JenisAkun $jenis_akun)
    {
        if ($response = $this->checkIzin('akses_edit_jenis_akun')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_akuns,nama,' . $jenis_akun->id,
        ]);

        $jenis_akun->update($validated);

        return redirect()->route('jenis_akun.index')->with('success', 'JenisAkun berhasil diperbarui.');
    }

    public function destroy(JenisAkun $jenis_akun)
    {
        if ($response = $this->checkIzin('akses_hapus_jenis_akun')) {
            return $response;
        }

        $jenis_akun->delete();

        return redirect()->route('jenis_akun.index')->with('success', 'JenisAkun berhasil dihapus.');
    }
}
