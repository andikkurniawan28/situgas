<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divisi_id')->constrained();
            $table->string('nama')->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Akses modul
            $table->boolean('akses_master')->default(0);
            $table->boolean('akses_customer_service')->default(0);
            $table->boolean('akses_tugas')->default(0);
            $table->boolean('akses_keuangan')->default(0);

            // Akses submodul
            $table->boolean('akses_master_daftar_divisi')->default(0);
            $table->boolean('akses_master_tambah_divisi')->default(0);
            $table->boolean('akses_master_edit_divisi')->default(0);
            $table->boolean('akses_master_hapus_divisi')->default(0);
            $table->boolean('akses_master_daftar_jabatan')->default(0);
            $table->boolean('akses_master_tambah_jabatan')->default(0);
            $table->boolean('akses_master_edit_jabatan')->default(0);
            $table->boolean('akses_master_hapus_jabatan')->default(0);
            $table->boolean('akses_master_daftar_user')->default(0);
            $table->boolean('akses_master_tambah_user')->default(0);
            $table->boolean('akses_master_edit_user')->default(0);
            $table->boolean('akses_master_hapus_user')->default(0);
            $table->boolean('akses_master_daftar_progress')->default(0);
            $table->boolean('akses_master_tambah_progress')->default(0);
            $table->boolean('akses_master_edit_progress')->default(0);
            $table->boolean('akses_master_hapus_progress')->default(0);
            $table->boolean('akses_master_daftar_level_klien')->default(0);
            $table->boolean('akses_master_tambah_level_klien')->default(0);
            $table->boolean('akses_master_edit_level_klien')->default(0);
            $table->boolean('akses_master_hapus_level_klien')->default(0);
            $table->boolean('akses_master_daftar_klien')->default(0);
            $table->boolean('akses_master_tambah_klien')->default(0);
            $table->boolean('akses_master_edit_klien')->default(0);
            $table->boolean('akses_master_hapus_klien')->default(0);
            $table->boolean('akses_master_daftar_produk')->default(0);
            $table->boolean('akses_master_tambah_produk')->default(0);
            $table->boolean('akses_master_edit_produk')->default(0);
            $table->boolean('akses_master_hapus_produk')->default(0);
            $table->boolean('akses_daftar_jenis_tiket')->default(0);
            $table->boolean('akses_tambah_jenis_tiket')->default(0);
            $table->boolean('akses_edit_jenis_tiket')->default(0);
            $table->boolean('akses_hapus_jenis_tiket')->default(0);
            $table->boolean('akses_daftar_tiket')->default(0);
            $table->boolean('akses_tambah_tiket')->default(0);
            $table->boolean('akses_edit_tiket')->default(0);
            $table->boolean('akses_detail_tiket')->default(0);
            $table->boolean('akses_hapus_tiket')->default(0);
            $table->boolean('akses_daftar_tugas_rutin')->default(0);
            $table->boolean('akses_tambah_tugas_rutin')->default(0);
            $table->boolean('akses_edit_tugas_rutin')->default(0);
            $table->boolean('akses_hapus_tugas_rutin')->default(0);
            $table->boolean('akses_daftar_tugas')->default(0);
            $table->boolean('akses_tambah_tugas')->default(0);
            $table->boolean('akses_edit_tugas')->default(0);
            $table->boolean('akses_detail_tugas')->default(0);
            $table->boolean('akses_hapus_tugas')->default(0);
            $table->boolean('akses_daftar_jenis_akun')->default(0);
            $table->boolean('akses_tambah_jenis_akun')->default(0);
            $table->boolean('akses_edit_jenis_akun')->default(0);
            $table->boolean('akses_hapus_jenis_akun')->default(0);
            $table->boolean('akses_daftar_akun')->default(0);
            $table->boolean('akses_tambah_akun')->default(0);
            $table->boolean('akses_edit_akun')->default(0);
            $table->boolean('akses_hapus_akun')->default(0);
            $table->boolean('akses_daftar_tagihan')->default(0);
            $table->boolean('akses_tambah_tagihan')->default(0);
            $table->boolean('akses_edit_tagihan')->default(0);
            $table->boolean('akses_detail_tagihan')->default(0);
            $table->boolean('akses_hapus_tagihan')->default(0);
            $table->boolean('akses_daftar_pelunasan')->default(0);
            $table->boolean('akses_tambah_pelunasan')->default(0);
            $table->boolean('akses_edit_pelunasan')->default(0);
            $table->boolean('akses_detail_pelunasan')->default(0);
            $table->boolean('akses_hapus_pelunasan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatans');
    }
};
