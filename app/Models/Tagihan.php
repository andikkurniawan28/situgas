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
}
