<?php

namespace App\Http\Controllers;

use App\Models\Pelunasan;
use App\Models\Tagihan;
use App\Models\User;
use App\Models\Akun;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PelunasanController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_daftar_pelunasan')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = Pelunasan::with(['tagihan', 'akun', 'user']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tagihan_keterangan', fn($row) => $row->tagihan->keterangan ?? '-')
                ->addColumn('akun_nama', fn($row) => $row->akun->nama ?? '-')
                ->addColumn('user_nama', fn($row) => $row->user->nama ?? '-')
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('pelunasan.edit', $row->id);
                    $showUrl = route('pelunasan.show', $row->id);
                    $deleteUrl = route('pelunasan.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <a href="' . $showUrl . '" class="btn btn-sm btn-info">Detail</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus pelunasan ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('pelunasan.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_tambah_pelunasan')) {
            return $response;
        }

        return view('pelunasan.create', [
            'tagihans' => Tagihan::where('lunas', false)->get(),
            'akuns' => Akun::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_tambah_pelunasan')) {
            return $response;
        }

        $request->request->add(['user_id' => auth()->id()]);

        $request->validate([
            'tagihan_id' => 'required|exists:tagihans,id',
            'akun_id' => 'required|exists:akuns,id',
            'total' => 'required|integer|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        Pelunasan::create($request->all());

        // Update status tagihan ke lunas
        $tagihan = Tagihan::find($request->tagihan_id);
        if ($tagihan && $tagihan->total <= $request->total) {
            $tagihan->lunas = true;
            $tagihan->save();
        }

        return redirect()->route('pelunasan.index')->with('success', 'Pelunasan berhasil ditambahkan');
    }

    public function show(Pelunasan $pelunasan)
    {
        if ($response = $this->checkIzin('akses_detail_pelunasan')) {
            return $response;
        }

        $pelunasan->load(['tagihan', 'akun', 'user']);
        return view('pelunasan.show', compact('pelunasan'));
    }

    public function edit(Pelunasan $pelunasan)
    {
        if ($response = $this->checkIzin('akses_edit_pelunasan')) {
            return $response;
        }

        return view('pelunasan.edit', [
            'pelunasan' => $pelunasan,
            'tagihans' => Tagihan::all(),
            'akuns' => Akun::all(),
        ]);
    }

    public function update(Request $request, Pelunasan $pelunasan)
    {
        if ($response = $this->checkIzin('akses_edit_pelunasan')) {
            return $response;
        }

        $request->validate([
            'tagihan_id' => 'required|exists:tagihans,id',
            'akun_id' => 'required|exists:akuns,id',
            'total' => 'required|integer|min:0',
        ]);

        $pelunasan->update($request->all());

        return redirect()->route('pelunasan.index')->with('success', 'Pelunasan berhasil diperbarui');
    }

    public function destroy(Pelunasan $pelunasan)
    {
        if ($response = $this->checkIzin('akses_hapus_pelunasan')) {
            return $response;
        }

        $pelunasan->delete();

        return redirect()->route('pelunasan.index')->with('success', 'Pelunasan berhasil dihapus');
    }
}
