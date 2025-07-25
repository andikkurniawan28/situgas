<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function delegasi()
    {
        return $this->belongsTo(User::class, 'didelegasikan_ke', 'id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh', 'id');
    }

    public function progress() { return $this->belongsTo(Progress::class); }
}
