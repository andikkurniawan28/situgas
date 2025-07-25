<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Klien;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_produk')) {
            return $response;
        }

        if ($request->ajax()) {
             $data = Produk::with('klien');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('level_nama', fn($row) => $row->klien->nama ?? '-')
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('produk.edit', $row->id);
                    $deleteUrl = route('produk.destroy', $row->id);
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

        return view('produk.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_produk')) {
            return $response;
        }

        return view('produk.create', [
            'kliens' => Klien::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_produk')) {
            return $response;
        }

        $validated = $request->validate([
            'klien_id'     => 'required|exists:kliens,id',
            'judul'        => 'required|string|max:255',
            'keterangan'   => 'required|string',
            'link_repo'    => 'required|url|max:255',
            'link_produk'  => 'required|url|max:255',
            'token'        => 'required|string|max:255',
            'status_aktif' => 'required|in:aktif,nonaktif', // contoh enum
        ]);

        Produk::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        if ($response = $this->checkIzin('akses_master_edit_produk')) {
            return $response;
        }

        return view('produk.edit', [
            'produk' => $produk,
            'kliens' => Klien::all(),
        ]);
    }

    public function update(Request $request, Produk $produk)
    {
        if ($response = $this->checkIzin('akses_master_edit_produk')) {
            return $response;
        }

        $validated = $request->validate([
            'klien_id'     => 'required|exists:kliens,id',
            'judul'        => 'required|string|max:255',
            'keterangan'   => 'required|string',
            'link_repo'    => 'required|url|max:255',
            'link_produk'  => 'required|url|max:255',
            'token'        => 'required|string|max:255',
            'status_aktif' => 'required|in:aktif,nonaktif',
        ]);

        $produk->update($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($response = $this->checkIzin('akses_master_hapus_produk')) {
            return $response;
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
