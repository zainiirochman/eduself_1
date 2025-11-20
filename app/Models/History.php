<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';
    protected $fillable = [
        'loan_id',
        'buku_id',
        'member_id',
        'loan_date',
        'due_date',
        'return_date',
        'fine'
    ];

    public function buku()
    {
        return $this->belongsTo(Book::class, 'buku_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
