<?php namespace CVA\Permissions\Abilities;



use CVA\Permissions\Contracts\IRoleable;

class RoleCanSee
{

    public function roleCanSee(IRoleable $person, $role) : bool
    {
        return $person->can($role);
    }


    public function roleCanAtleast(IRoleable $person, $roles)
    {
        $roles = explode(', ', $roles);
        return $person->canAtLeast($roles);
    }
}