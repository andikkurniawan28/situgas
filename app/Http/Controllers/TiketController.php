<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Klien;
use App\Models\JenisTiket;
use App\Models\User;
use App\Models\Progress;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TiketController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_tiket')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Tiket::with(['klien', 'jenis_tiket', 'progress', 'delegasi', 'pembuat']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('progress', function ($row) {
                    if ($row->progress) {
                        return '<span class="badge bg-' . $row->progress->warna . ' text-white">' . $row->progress->nama . '</span>';
                    }
                    return '-';
                })
                ->addColumn('klien_nama', function ($row) {
                    if ($row->klien) {
                        return $row->klien->nama .
                            ' <sub><span class="badge bg-' . $row->klien->level_klien->warna . '">' . ucfirst($row->klien->level_klien->nama) . '</span></sub>';
                    }
                    return '-';
                })
                ->addColumn('jenis', fn($row) => $row->jenis_tiket->nama ?? '-')
                ->addColumn('pembuat', fn($row) => $row->pembuat->nama ?? '-')
                ->addColumn('delegasi', fn($row) => $row->delegasi->nama ?? '-')
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('tiket.edit', $row->id);
                    $showUrl = route('tiket.show', $row->id);
                    $deleteUrl = route('tiket.destroy', $row->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                    <a href="' . $showUrl . '" class="btn btn-sm btn-info">Detail</a>
                    <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus tiket ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                ';
                })
                ->rawColumns(['aksi', 'klien_nama', 'progress'])
                ->make(true);
        }

        return view('tiket.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_tiket')) {
            return $response;
        }

        return view('tiket.create', [
            'kliens' => Klien::all(),
            'jenis_tikets' => JenisTiket::all(),
            'users' => User::all(),
            'progresses' => Progress::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_tiket')) {
            return $response;
        }

        $request->request->add(['dibuat_oleh' => Auth()->user()->id]);

        $request->validate([
            'klien_id' => 'required|exists:kliens,id',
            'jenis_tiket_id' => 'required|exists:jenis_tikets,id',
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
                $data[$gambar] = $request->file($gambar)->store('tiket', 'public');
            }
        }

        Tiket::create($data);

        return redirect()->route('tiket.index')->with('success', 'Tiket berhasil ditambahkan');
    }

    public function show(Tiket $tiket)
    {
        if ($response = $this->checkIzin('akses_detail_tiket')) {
            return $response;
        }
        $tiket->load(['klien', 'jenis_tiket', 'delegasi', 'pembuat', 'progress']);
        return view('tiket.show', compact('tiket'));
    }

    public function edit(Tiket $tiket)
    {
        if ($response = $this->checkIzin('akses_edit_tiket')) {
            return $response;
        }

        return view('tiket.edit', [
            'tiket' => $tiket,
            'kliens' => Klien::all(),
            'jenis_tikets' => JenisTiket::all(),
            'users' => User::all(),
            'progresses' => Progress::all(),
        ]);
    }

    public function update(Request $request, Tiket $tiket)
    {
        if ($response = $this->checkIzin('akses_edit_tiket')) {
            return $response;
        }

        $request->validate([
            'klien_id' => 'required|exists:kliens,id',
            'jenis_tiket_id' => 'required|exists:jenis_tikets,id',
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
                $data[$gambar] = $request->file($gambar)->store('tiket', 'public');
            }
        }

        $tiket->update($data);

        return redirect()->route('tiket.index')->with('success', 'Tiket berhasil diperbarui');
    }

    public function destroy(Tiket $tiket)
    {
        if ($response = $this->checkIzin('akses_hapus_tiket')) {
            return $response;
        }
        $tiket->delete();
        return redirect()->route('tiket.index')->with('success', 'Tiket berhasil dihapus');
    }
}
