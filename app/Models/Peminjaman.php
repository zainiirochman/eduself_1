<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman'; 

    protected $fillable = [
        'buku_id',
        'anggota_id', 
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'denda',
    ];

    public function buku()
    {
        return $this->belongsTo(Book::class);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
