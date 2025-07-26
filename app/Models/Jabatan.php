<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function divisi(){
        return $this->belongsTo(Divisi::class);
    }

    public static function semuaAkses(){
        $array_akses = [
            'akses_master',
            'akses_customer_service',
            'akses_tugas',
            'akses_keuangan',
            'akses_master_daftar_divisi',
            'akses_master_tambah_divisi',
            'akses_master_edit_divisi',
            'akses_master_hapus_divisi',
            'akses_master_daftar_jabatan',
            'akses_master_tambah_jabatan',
            'akses_master_edit_jabatan',
            'akses_master_hapus_jabatan',
            'akses_master_daftar_user',
            'akses_master_tambah_user',
            'akses_master_edit_user',
            'akses_master_hapus_user',
            'akses_master_daftar_progress',
            'akses_master_tambah_progress',
            'akses_master_edit_progress',
            'akses_master_hapus_progress',
            'akses_master_daftar_level_klien',
            'akses_master_tambah_level_klien',
            'akses_master_edit_level_klien',
            'akses_master_hapus_level_klien',
            'akses_master_daftar_klien',
            'akses_master_tambah_klien',
            'akses_master_edit_klien',
            'akses_master_hapus_klien',
            'akses_master_daftar_produk',
            'akses_master_tambah_produk',
            'akses_master_edit_produk',
            'akses_master_hapus_produk',
            'akses_daftar_jenis_tiket',
            'akses_tambah_jenis_tiket',
            'akses_edit_jenis_tiket',
            'akses_hapus_jenis_tiket',
            'akses_daftar_tiket',
            'akses_tambah_tiket',
            'akses_edit_tiket',
            'akses_detail_tiket',
            'akses_hapus_tiket',
            'akses_daftar_tugas_rutin',
            'akses_tambah_tugas_rutin',
            'akses_edit_tugas_rutin',
            'akses_hapus_tugas_rutin',
            'akses_daftar_tugas',
            'akses_tambah_tugas',
            'akses_edit_tugas',
            'akses_detail_tugas',
            'akses_hapus_tugas',
            'akses_daftar_jenis_akun',
            'akses_tambah_jenis_akun',
            'akses_edit_jenis_akun',
            'akses_hapus_jenis_akun',
            'akses_daftar_akun',
            'akses_tambah_akun',
            'akses_edit_akun',
            'akses_hapus_akun',
            'akses_daftar_tagihan',
            'akses_tambah_tagihan',
            'akses_edit_tagihan',
            'akses_detail_tagihan',
            'akses_hapus_tagihan',
            'akses_daftar_pelunasan',
            'akses_tambah_pelunasan',
            'akses_edit_pelunasan',
            'akses_detail_pelunasan',
            'akses_hapus_pelunasan',
        ];
        return $array_akses;
    }
}
