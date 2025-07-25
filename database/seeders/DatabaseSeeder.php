<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Klien;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\JenisAkun;
use App\Models\Progress;
use App\Models\JenisTiket;
use App\Models\LevelKlien;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Divisi::insert([
            ['nama' => 'Direksi'],
            ['nama' => 'Teknologi'],
            ['nama' => 'Penjualan'],
            ['nama' => 'Dukungan Pelanggan'],
            ['nama' => 'Administrasi Keuangan'],
        ]);

        $jabatan = Jabatan::create([
            'nama' => 'Direktur',
            'divisi_id' => 1,
        ]);
        $array_akses = Jabatan::semuaAkses();
        $updateData = array_fill_keys($array_akses, 1);
        $jabatan->update($updateData);

        User::insert([
            ['nama' => 'Budiono Siregar', 'jabatan_id' => 1, 'username' => 'budi', 'password' => bcrypt('budi')],
            // ['nama' => 'Bobby Saputra', 'jabatan_id' => 2, 'username' => 'bobby', 'password' => bcrypt('bobby')],
            // ['nama' => 'Chandra Handika', 'jabatan_id' => 3, 'username' => 'chandra', 'password' => bcrypt('chandra')],
            // ['nama' => 'Dini Saputri', 'jabatan_id' => 4, 'username' => 'dini', 'password' => bcrypt('dini')],
            // ['nama' => 'Eka Firanda', 'jabatan_id' => 5, 'username' => 'eka', 'password' => bcrypt('eka')],
        ]);

        Progress::insert([
            ['nama' => 'Terbuka', 'warna' => 'primary'],
            ['nama' => 'Dikerjakan', 'warna' => 'secondary'],
            ['nama' => 'Butuh Review', 'warna' => 'warning'],
            ['nama' => 'Selesai', 'warna' => 'success'],
        ]);

        JenisTiket::insert([
            ['nama' => 'Kendala Produk'],
            ['nama' => 'Kendala Akun'],
            ['nama' => 'Pembayaran'],
        ]);

        LevelKlien::insert([
            ['nama' => 'Lead', 'warna' => 'primary'],
            ['nama' => 'Prospek', 'warna' => 'secondary'],
            ['nama' => 'Pengguna', 'warna' => 'success'],
            ['nama' => 'Promotor', 'warna' => 'info'],
        ]);

        Klien::insert([
            [
                'nama' => 'Pak Winarno',
                'perusahaan' => 'PG Kebon Agung',
                'bidang_usaha' => 'Pabrik Gula',
                'whatsapp' => '081279241338',
                'level_klien_id' => 2,
            ],
            [
                'nama' => 'Pak Paul',
                'perusahaan' => 'PT Valid Data Solusi',
                'bidang_usaha' => 'Software House',
                'whatsapp' => '081279241337',
                'level_klien_id' => 2,
            ],
        ]);

        JenisAkun::insert([
            ['nama' => 'Aset'],
            ['nama' => 'Kewajiban'],
            ['nama' => 'Modal'],
            ['nama' => 'Pendapatan'],
            ['nama' => 'Beban'],
        ]);
    }
}
