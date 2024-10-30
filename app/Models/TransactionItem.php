<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $guarded = [];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function gun()
    {
        return $this->belongsTo(Gun::class);
    }

    public function caliber()
    {
        return $this->belongsTo(Caliber::class);
    }

    public function corridor()
    {
        return $this->belongsTo(Corridor::class);
    }
}
