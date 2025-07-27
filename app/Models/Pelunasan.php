<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelunasan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tagihan(){
        return $this->belongsTo(Tagihan::class);
    }

    public function akun(){
        return $this->belongsTo(Akun::class);
    }

    public static function catatBukuBesar($pelunasan){
        $keterangan = 'Pelunasan - ' . $pelunasan->tagihan->klien->nama;
        BukuBesar::insert([
            'pelunasan_id' => $pelunasan->id,
            'akun_id' => 3,
            'keterangan' => $keterangan,
            'kredit' => $pelunasan->total,
            'user_id' => $pelunasan->user_id,
        ]);
        BukuBesar::insert([
            'pelunasan_id' => $pelunasan->id,
            'akun_id' => $pelunasan->akun_id,
            'keterangan' => $keterangan,
            'debit' => $pelunasan->total,
            'user_id' => $pelunasan->user_id,
        ]);
    }

    public static function catatPiutang($pelunasan)
    {
        // Dapatkan klien terkait
        $klien = Klien::find($pelunasan->tagihan->klien_id);

        if (!$klien) return;

        // Hitung piutang sekarang
        $piutang_terakhir = $klien->piutang;
        $piutang_sekarang = $piutang_terakhir - $pelunasan->total;

        $klien->update(['piutang' => $piutang_sekarang]);

        // Cek total pelunasan untuk tagihan tersebut
        $total_pelunasan = Pelunasan::where('tagihan_id', $pelunasan->tagihan_id)->sum('total');

        // Update status lunas jika total pelunasan >= tagihan
        if ($total_pelunasan >= $pelunasan->tagihan->total) {
            $pelunasan->tagihan->update(['lunas' => 1]);
        }
    }

    public static function updateBukuBesar($pelunasan){
        BukuBesar::where('pelunasan_id', $pelunasan->id)->delete();
        self::catatBukuBesar($pelunasan);
    }

    public static function updatePiutang($pelunasan, $old_total)
    {
        // Ambil klien terkait
        $klien = Klien::find($pelunasan->tagihan->klien_id);

        if (!$klien) return;

        // Piutang sebelumnya dikoreksi dulu dengan old_total
        $piutang_sebelum = $klien->piutang + $old_total;

        // Piutang setelah pelunasan baru
        $piutang_sekarang = $piutang_sebelum - $pelunasan->total;

        $klien->update(['piutang' => $piutang_sekarang]);

        // Hitung total pelunasan untuk tagihan tersebut
        $total_pelunasan = Pelunasan::where('tagihan_id', $pelunasan->tagihan_id)->sum('total');

        // Update status tagihan jika lunas
        if ($total_pelunasan >= $pelunasan->tagihan->total) {
            $pelunasan->tagihan->update(['lunas' => 1]);
        } else {
            $pelunasan->tagihan->update(['lunas' => 0]);
        }
    }

    public static function resetPiutang($pelunasan){
        $piutang_terakhir = Klien::whereId($pelunasan->tagihan->klien_id)->get()->last()->piutang;
        $piutang_sekarang = $piutang_terakhir + $pelunasan->total;
        Klien::whereId($pelunasan->tagihan->klien_id)->update(['piutang' => $piutang_sekarang]);
    }

}
