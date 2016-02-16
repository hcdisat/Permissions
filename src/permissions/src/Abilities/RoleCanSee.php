<?php namespace ITeam\Permissions\Abilities;


use Hcdisat\Permissions\Models\Person;

class RoleCanSee
{

    public function roleCanSee(Person $person, $role) : bool
    {
        return $person->has($role);
    }

    public function hasPermission(Person $person, $permissions) : bool
    {
        return $person->can($permissions);
    }

    public function canAtleast(Person $person, $permissions)
    {
        $permissions = explode(', ', $permissions);
        return $person->canAtLeast($permissions);
    }
}