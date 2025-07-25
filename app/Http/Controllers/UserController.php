<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_daftar_user')) {
            return $response;
        }

        if ($request->ajax()) {
            $data = User::with('jabatan');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jabatan_nama', fn($row) => $row->jabatan->nama ?? '-')
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('user.edit', $row->id);
                    $deleteUrl = route('user.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Hapus data ini?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    ';
                })
                ->addColumn('status_aktif', function ($row) {
                    if ($row->status_aktif) {
                        return '<span class="badge bg-primary text-light">Aktif</span>';
                    } else {
                        return '<span class="badge bg-dark text-light">Tidak Aktif</span>';
                    }
                })
                ->rawColumns(['aksi', 'status_aktif'])
                ->make(true);
        }

        return view('user.index');
    }

    public function create()
    {
        if ($response = $this->checkIzin('akses_master_tambah_user')) {
            return $response;
        }

        return view('user.create', [
            'jabatans' => Jabatan::all(),
        ]);
    }

    public function store(Request $request)
    {
        if ($response = $this->checkIzin('akses_master_tambah_user')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:users,nama',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'jabatan_id' => 'required|exists:jabatans,id',
            'status_aktif' => 'nullable|boolean',
        ]);

        $userData = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'jabatan_id' => $validated['jabatan_id'],
            'status_aktif' => $request->has('status_aktif') ? 1 : 0,
        ];

        User::create($userData);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if ($response = $this->checkIzin('akses_master_edit_user')) {
            return $response;
        }

        return view('user.edit', [
            'user' => $user,
            'jabatans' => Jabatan::all(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        if ($response = $this->checkIzin('akses_master_edit_user')) {
            return $response;
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:users,nama,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'jabatan_id' => 'required|exists:jabatans,id',
            'status_aktif' => 'nullable|boolean',
        ]);

        $userData = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'jabatan_id' => $validated['jabatan_id'],
            'status_aktif' => $request->has('status_aktif') ? 1 : 0,
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = bcrypt($validated['password']);
        }

        $user->update($userData);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($response = $this->checkIzin('akses_master_hapus_user')) {
            return $response;
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
