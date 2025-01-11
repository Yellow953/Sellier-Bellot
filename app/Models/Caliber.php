<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caliber extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function can_delete()
    {
        return $this->items()->count() == 0 && auth()->user()->role == 'admin';
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('name')) {
            $name = request('name');
            $q->where('name', 'LIKE', "%{$name}%");
        }
        if (request('make')) {
            $make = request('make');
            $q->where('make', 'LIKE', "%{$make}%");
        }


        return $q;
    }
}
