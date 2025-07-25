<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jenis_akun(){
        return $this->belongsTo(JenisAkun::class);
    }
}
