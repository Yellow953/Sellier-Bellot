<?php

namespace App\Helpers;

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
}
