<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function klien(){
        return $this->belongsTo(Klien::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pelunasan(){
        return $this->hasMany(Pelunasan::class);
    }

    public static function catatBukuBesar($tagihan){
        $keterangan = $tagihan->keterangan . ' - ' . $tagihan->klien->nama;
        BukuBesar::insert([
            'tagihan_id' => $tagihan->id,
            'akun_id' => 3,
            'keterangan' => $keterangan,
            'debit' => $tagihan->total,
            'user_id' => $tagihan->user_id,
        ]);
        BukuBesar::insert([
            'tagihan_id' => $tagihan->id,
            'akun_id' => 10,
            'keterangan' => $keterangan,
            'kredit' => $tagihan->total,
            'user_id' => $tagihan->user_id,
        ]);
    }

    public static function catatPiutang($tagihan){
        $piutang_terakhir = Klien::whereId($tagihan->klien_id)->get()->last()->piutang;
        $piutang_sekarang = $piutang_terakhir + $tagihan->total;
        Klien::whereId($tagihan->klien_id)->update(['piutang' => $piutang_sekarang]);
    }

    public static function updateBukuBesar($tagihan){
        BukuBesar::where('tagihan_id', $tagihan->id)->delete();
        self::catatBukuBesar($tagihan);
    }

    public static function updatePiutang($tagihan, $request){
        $piutang_terakhir = Klien::whereId($tagihan->klien_id)->get()->last()->piutang;
        $piutang_sekarang = $piutang_terakhir - $request->old_total;
        Klien::whereId($tagihan->klien_id)->update(['piutang' => $piutang_sekarang]);
        self::catatPiutang($tagihan);
    }

    public static function resetPiutang($tagihan){
        $piutang_terakhir = Klien::whereId($tagihan->klien_id)->get()->last()->piutang;
        $piutang_sekarang = $piutang_terakhir - $tagihan->total;
        Klien::whereId($tagihan->klien_id)->update(['piutang' => $piutang_sekarang]);
    }
}
