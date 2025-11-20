<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loans'; 

    protected $fillable = [
        'buku_id',
        'member_id', 
        'loan_date',
        'due_date',
        'fine',
    ];

    public function buku()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
