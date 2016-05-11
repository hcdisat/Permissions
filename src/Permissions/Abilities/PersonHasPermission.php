<?php namespace CVA\Permissions\Abilities;


use CVA\Permissions\Contracts\IPermissable;

class PersonHasPermission
{
    public function hasPermissions(IPermissable $person, $permission) : bool
    {
        return $person->has($permission);
    }


    public function hasAtLeast(IPermissable $person, $permissions)
    {
        $permissions = explode(', ', $permissions);
        return $person->hasAtLeast($permissions);
    }
}