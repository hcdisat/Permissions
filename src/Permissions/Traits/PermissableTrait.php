<?php namespace CVA\Permissions\Traits;


trait PermissableTrait
{
    /**
     * checks if person has one or many permissions
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission) : bool
    {
        // get permissions
        $permissions = $this->getPermissions();

        // check if the parameter is an array
        if( is_array($permission) )
        {
            // Count the intersection
            $intersectionCount = array_intersect($permissions, $permission);
            return
                // if equals then ew grant access
                count($permission) == count($intersectionCount);
        }

        // if not check if the permission is in the list
        return in_array($permission, $permissions);
    }

    /**
     * Checks if the permissions list has at least one of the given permissions
     * @param array $permission
     * @return bool
     */
    public function hasAtLeast(array $permission) : bool
    {
        if( empty($permission )) return false;

        $permissions = $this->getPermissions();

        $intersection = array_intersect($permissions, $permission);

        return count($intersection) > 0;
    }

    /**
     * Get all permissions slugs
     * @return array
     */
    public function getPermissions() : array
    {
        return !is_null($this->permissions)
            ? $this->permissions()->pluck('slug')->all()
            : [];
    }

    /**
     * Assign a Permissions to a Person
     * @param int $permissionId
     * @return bool
     */
    public function assignPermission($permissionId) : bool
    {
        if( !$this->permissions->contains($permissionId))
        {
            $this->permissions()->attach($permissionId);
            return true;
        }
        return false;
    }

    /**
     * Adda various permissions
     * @param array $permissions
     * @return int
     */
    public function assignPermissions(array $permissions) : int
    {
        // if empty return 0
        if( empty($permissions) ) return 0;

        $counter = 0;
        // check if all members are actually numbers
        foreach ($permissions as $permission)
        {
            $this->assignPermission($permission);
            $counter++;
        }

        return $counter;
    }

    /**
     * Removes a permission
     * @param string $permission
     * @return int
     */
    public function revokePermission($permission = '') : int
    {
        return $this->permissions()->detach($permission);
    }

    /**
     * Syncs the given permissions
     * @param array $permissions
     * @return array
     */
    public function syncPermissions(array $permissions) : array
    {
        return $this->permissions()->sync($permissions);
    }

    /**
     * Revoke all permissions
     * @return int
     */
    public function revokeAllPermissions() : int
    {
        return $this->permissions()
            ->detach();
    }
}