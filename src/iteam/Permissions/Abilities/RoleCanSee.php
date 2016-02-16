<?php namespace ITeam\Permissions\Abilities;



use ITeam\Permissions\Contracts\IRoleable;

class RoleCanSee
{

    public function roleCanSee(IRoleable $person, $role) : bool
    {
        return $person->has($role);
    }

    public function hasPermission(IRoleable $person, $permissions) : bool
    {
        return $person->can($permissions);
    }

    public function canAtleast(IRoleable $person, $permissions)
    {
        $permissions = explode(', ', $permissions);
        return $person->canAtLeast($permissions);
    }
}