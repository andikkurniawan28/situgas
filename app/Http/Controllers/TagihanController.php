<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Klien;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_tagihan')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Tagihan::with(['klien', 'user']);

            return DataTables::of($data)
                ->filterColumn('klien_nama', function ($query, $keyword) {
                    $query->whereHas('klien', function ($q) use ($keyword) {
                        $q->where('nama', 'like', "%$keyword%");
                    });
                })
                ->filterColumn('user_nama', function ($query, $keyword) {
                    $query->whereHas('user', function ($q) use ($keyword) {
                        $q->where('nama', 'like', "%$keyword%");
                    });
                })
                ->filterColumn('status', function ($query, $keyword) {
                    if (stripos($keyword, 'lunas') !== false) {
                        $query->where('lunas', 1);
                    } elseif (stripos($keyword, 'belum') !== false) {
                        $query->where('lunas', 0);
                    }
                })
                ->addIndexColumn()
                ->addColumn('klien_nama', function ($row) {
                    return $row->klien->nama ?? '-';
                })
                ->addColumn('user_nama', function ($row) {
                    return $row->user->nama ?? '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->lunas
                        ? '<span class="badge bg-success">Lunas</span>'
                        : '<span class="badge bg-danger">Belum Lunas</span>';
                })
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('tagihan.edit', $row->id);
                    $showUrl = route('tagihan.show', $row->id);
                    $deleteUrl = route('tagihan.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <a href="' . $showUrl . '" class="btn btn-sm btn-info">Detail</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus tagihan ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['aksi', 'status'])
                ->make(true);
        }

        return view('tagihan.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_tagihan')) {
            return $response;
        }

        return view('tagihan.create', [
            'kliens' => Klien::all(),
            'users' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_tagihan')) {
            return $response;
        }

        $request->request->add(['user_id' => auth()->id()]);

        $request->validate([
            'terbit' => 'required|date',
            'jatuh_tempo' => 'required|date',
            'klien_id' => 'required|exists:kliens,id',
            'keterangan' => 'required|string',
            'total' => 'required|integer|min:0',
            // 'lunas' => 'nullable|boolean',
            'user_id' => 'required|exists:users,id',
        ]);

        Tagihan::create($request->all());

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan');
    }

    public function show(Tagihan $tagihan)
    {
        if ($response = $this->checkIzin('akses_detail_tagihan')) {
            return $response;
        }

        $tagihan->load(['klien', 'user']);
        return view('tagihan.show', compact('tagihan'));
    }

    public function edit(Tagihan $tagihan)
    {
        if ($response = $this->checkIzin('akses_edit_tagihan')) {
            return $response;
        }

        return view('tagihan.edit', [
            'tagihan' => $tagihan,
            'kliens' => Klien::all(),
            'users' => User::all(),
        ]);
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        if ($response = $this->checkIzin('akses_edit_tagihan')) {
            return $response;
        }

        $request->validate([
            'terbit' => 'required|date',
            'jatuh_tempo' => 'required|date',
            'klien_id' => 'required|exists:kliens,id',
            'keterangan' => 'required|string',
            'total' => 'required|integer|min:0',
            'lunas' => 'required|boolean',
            // 'user_id' => 'required|exists:users,id',
        ]);

        $tagihan->update($request->all());

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diperbarui');
    }

    public function destroy(Tagihan $tagihan)
    {
        if ($response = $this->checkIzin('akses_hapus_tagihan')) {
            return $response;
        }

        $tagihan->delete();

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus');
    }
}
