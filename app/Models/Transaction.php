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
 	if (request('transaction_start_date') || request('endDate')) {
            $transaction_start_date = request()->query('transaction_start_date') ?? Carbon::today();
            $transaction_end_date = request()->query('transaction_end_date') ?? Carbon::today()->addYears(100);
            $q->whereBetween('created_at', [$transaction_start_date, $transaction_end_date]);
        }
        if (request('user_id')) {
            $user_id = request('user_id');
            $q->where('user_id', $user_id);
        }
        if (request('customer_id')) {
            $customer_id = request('customer_id');
            $q->where('customer_id', $customer_id);
        }
        if (request('pistol_source')) {
            $pistol_source = request('pistol_source');
            $q->where('pistol_source', $pistol_source);
        }
        if (request('ammo_source')) {
            $ammo_source = request('ammo_source');
            $q->where('ammo_source', $ammo_source);
        }

        return $q;
    }
}
