<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\JenisAkun;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_akun')) {
            return $response;
        }

        if ($request->ajax()) {
             $data = Akun::with('jenis_akun');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jenis_akun_nama', fn($row) => $row->jenis_akun->nama ?? '-')
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('akun.edit', $row->id);
                    $deleteUrl = route('akun.destroy', $row->id);
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

        return view('akun.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_akun')) {
            return $response;
        }

        return view('akun.create', [
            'jenis_akuns' => JenisAkun::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_akun')) {
            return $response;
        }

        $validated = $request->validate([
            'jenis_akun_id'     => 'required|exists:jenis_akuns,id',
            'kode'        => 'required|string|max:255',
            'nama'   => 'required|string',
            'saldo_normal' => 'required|in:debit,kredit', // contoh enum
        ]);

        Akun::create($validated);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(Akun $akun)
    {
        if ($response = $this->checkIzin('akses_edit_akun')) {
            return $response;
        }

        return view('akun.edit', [
            'akun' => $akun,
            'jenis_akuns' => JenisAkun::all(),
        ]);
    }

    public function update(Request $request, Akun $akun)
    {
        if ($response = $this->checkIzin('akses_edit_akun')) {
            return $response;
        }

        $validated = $request->validate([
            'jenis_akun_id'     => 'required|exists:jenis_akuns,id',
            'kode'        => 'required|string|max:255',
            'nama'   => 'required|string',
            'saldo_normal' => 'required|in:debit,kredit',
        ]);

        $akun->update($validated);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(Akun $akun)
    {
        if ($response = $this->checkIzin('akses_hapus_akun')) {
            return $response;
        }

        $akun->delete();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}
