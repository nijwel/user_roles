<?php

if (!function_exists('isPermission')) {
    function isPermission($permissiom)
    {

        return auth()->user()->hasPermission($permissiom);
    }
}

if (!function_exists('has_anypermission')) {
    function has_anypermission(array $permissions)
    {

        foreach ($permissions as $permission) {
            return auth()->user()->hasPermission($permission);
        }
    }
}