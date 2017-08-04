<?php namespace HcDisat\Permissions\Abilities;


use HcDisat\Permissions\Contracts\IPermissable;

class PersonHasPermission
{
    public function hasPermissions(IPermissable $person, $permission) : bool
    {
        return $person->hasPermission($permission);
    }


    public function hasAtLeast(IPermissable $person, $permissions)
    {
        $permissions = explode(', ', $permissions);
        return $person->hasAtLeast($permissions);
    }
}