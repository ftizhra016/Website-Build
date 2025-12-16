<?php
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

if (!function_exists('active_class')) {
    function active_class($path, $active = 'active')
    {
        return call_user_func_array('Request::is', (array)$path) ? $active : '';
    }
}
