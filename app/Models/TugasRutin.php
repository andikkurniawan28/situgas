<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasRutin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jabatan(){
        return $this->belongsTo(Jabatan::class);
    }

    public function progress(){
        return $this->belongsTo(Progress::class);
    }
}
