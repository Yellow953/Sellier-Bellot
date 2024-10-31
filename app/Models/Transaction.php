<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function can_delete()
    {
        return auth()->user()->role == 'admin';
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('transaction_date')) {
            $transaction_date = request('transaction_date');
            $q->where('transaction_date', 'LIKE', "%{$transaction_date}%");
        }
        if (request('user_id')) {
            $user_id = request('user_id');
            $q->where('user_id', $user_id);
        }
        if (request('customer_id')) {
            $customer_id = request('customer_id');
            $q->where('customer_id', $customer_id);
        }
        if (request('gun_source')) {
            $gun_source = request('gun_source');
            $q->where('gun_source', $gun_source);
        }
        if (request('ammo_source')) {
            $ammo_source = request('ammo_source');
            $q->where('ammo_source', $ammo_source);
        }

        return $q;
    }
}
