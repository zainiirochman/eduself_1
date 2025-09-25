<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman'; // pastikan sesuai nama tabel di database

    protected $fillable = [
        'buku_id',
        'anggota_id', // Ubah peminjam_id menjadi anggota_id
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'denda',
    ];

    public function buku()
    {
        return $this->belongsTo(Book::class); // Ubah Buku menjadi Book
    }

    public function anggota() // Ubah peminjam menjadi anggota
    {
        return $this->belongsTo(Anggota::class); // Ubah Peminjam menjadi Anggota
    }
}
