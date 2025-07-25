<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function klien() { return $this->belongsTo(Klien::class); }

    public function jenis_tiket() { return $this->belongsTo(JenisTiket::class); }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh', 'id');
    }

    public function delegasi()
    {
        return $this->belongsTo(User::class, 'didelegasikan_ke', 'id');
    }

    public function progress() { return $this->belongsTo(Progress::class); }

}
