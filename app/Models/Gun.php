<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gun extends Model
{
    protected $guarded = [];

    public function can_delete()
    {
        return auth()->user->role == 'admin';
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
