<?php

namespace App\Helpers;

use App\Models\Customer;
use App\Models\User;

class Helper
{
    public static function get_user_roles()
    {
        return ['admin', 'user'];
    }

    public static function get_sources()
    {
        return ['Self', 'Club'];
    }

    public static function get_users()
    {
        return User::select('id', 'name')->get();
    }

    public static function get_customers()
    {
        return Customer::select('id', 'name')->get();
    }
}
