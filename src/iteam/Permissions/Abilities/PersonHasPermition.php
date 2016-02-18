<?php namespace ITeam\Permissions\Abilities;


use ITeam\Permissions\Contracts\IPermissable;

class PersonHasPermition
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