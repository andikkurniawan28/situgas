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
}
