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

    public function pistol()
    {
        return $this->belongsTo(Pistol::class);
    }

    public function caliber()
    {
        return $this->belongsTo(Caliber::class);
    }

    public function lane()
    {
        return $this->belongsTo(Lane::class);
    }
}
