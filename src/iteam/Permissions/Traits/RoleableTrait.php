<?php namespace ITeam\Permissions\Traits;

use ITeam\Permissions\Models\Permission;
use ITeam\Permissions\Models\Role;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait RoleableTrait
{
    /**
     * Get all roles
     * @return array|null
     */
    public function getRoles() : array
    {
        return !is_null($this->roles)
            ? $this->roles->pluck('slug')->all()
            : [];
    }


    /**
     * Assign a Role to a Network
     * @param int $roleId
     * @return bool
     */
    public function assignRole($roleId) : bool
    {
        if( !$this->roles->contains($roleId))
        {
            $this->roles()->attach($roleId);
            return true;
        }
        return false;
    }

    /**
     * Adda various roles
     * @param array $roles
     * @return int
     */
    public function addRoles(array $roles) : int
    {
        // if empty return 0
        if( empty($roles) ) return 0;

        $counter = 0;
        // check if all members are actually numbers
        foreach ($roles as $role)
        {
            $this->assignRole($role);
            $counter++;
        }

        return $counter;
    }

    /**
     * Removes a role
     * @param string $roleId
     * @return int
     */
    public function revokeRole($roleId = '') : int
    {
        return $this->roles()->detach($roleId);
    }

    /**
     * Syncs the given role or roles
     * @param array $roles
     * @return array
     */
    public function syncRoles(array $roles) : array
    {
        return $this->roles()->sync($roles);
    }


    /**
     * Revoke all roles
     * @return int
     */
    public function revokeAllRoles() : int
    {
        return $this->roles()
            ->detach();
    }

    /**
     * checks if the person has a given role
     * @param mixed $role
     * @param array $arguments (necesary for the laravel' Gate can method)
     * @return bool
     */
    public function can($role, $arguments = []) : bool
    {
        // get roles
        $roles = $this->getRoles();

        // check if the parameter is an array
        if( is_array($role) )
        {
            // Count the interection
            $interectionCount = array_intersect($roles, $role);
            return
                // if equals then ew grant access
                count($role) == count($interectionCount);
        }

        // if not check if the permission is in the list
        return in_array($role, $roles);
    }


    /**
     * Checks if the role has at least one of the given permissions
     * @param array $rolesArray
     * @return bool
     */
    public function canAtLeast(array $rolesArray) : bool
    {
        if( empty($rolesArray )) return false;

        $roles = $this->getRoles();

        $intersection = array_intersect($roles, $rolesArray);

        return count($intersection) > 0;
    }
}