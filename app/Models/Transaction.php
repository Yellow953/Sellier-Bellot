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
        return $this->items->count() == 0  && auth()->user()->role == 'admin';
    }

    // Filter
    public function scopeFilter($q)
    {
        if (request('transaction_date')) {
            $transaction_date = request('transaction_date');
            $q->where('transaction_date', 'LIKE', "%{$transaction_date}%");
        }
        if (request('customer_name')) {
            $customer_name = request('customer_name');
            $q->where('customer_name', 'LIKE', "%{$customer_name}%");
        }
        if (request('customer_address')) {
            $customer_address = request('customer_address');
            $q->where('customer_address', 'LIKE', "%{$customer_address}%");
        }
        if (request('customer_phone')) {
            $customer_phone = request('customer_phone');
            $q->where('customer_phone', $customer_phone);
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
