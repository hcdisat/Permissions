<?php namespace ITeam\Permissions\Traits;

use ITeam\Permissions\Models\Permission;
use ITeam\Permissions\Models\Role;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait RoleTrait
{
    /*
	|----------------------------------------------------------------------
	| Role Trait Methods
	|----------------------------------------------------------------------
	|
	*/

    /**
     * Has many Roles Polymorphic
     * @return MorphToMany
     */
    public function roles() : MorphToMany
    {
        return $this->morphToMany(Role::class, 'roleable');
    }

    /**
     * Has many Permissions Polymorphic
     * @return MorphToMany
     */
    public function permissions() : MorphToMany
    {
        return $this->morphToMany(Permission::class, 'permissable');
    }

    /**
     * Get all roles
     * @return array|null
     */
    public function getRoles()
    {
        return !is_null($this->roles)
            ? $this->roles->pluck('slug')->all()
            : null;
    }

    /**
     * checks if user has the given role
     * @param $slug
     * @return bool
     */
    public function has($slug)
    {
        $slug = strtolower($slug);

        foreach ($this->roles as $role)
        {
            if( $role->slug == $slug ){
                return true;
            }
        }

        return false;
    }


    /**
     * Assign a Role to a Person
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
        // if empty return false
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
     * Revoke all roles in the object
     * @return int
     */
    public function revokeAllRoles() : int
    {
        return $this->roles()
            ->detach();
    }

    /**
     * Get all Role permissions
     * @return array
     */
    public function getPermissions() : array
    {
        $permitions = [[], []];

        foreach ($this->roles as $role) {
            $permitions[] = $role->getPermissions();
        }

        return call_user_func('array_merge', $permitions);
    }

    /**
     * Check if person has the given permission
     * @param $permission
     * @return bool
     */
    public function can($permission, $arguments = []) : bool
    {
        $can = false;

        foreach ($this->roles as $role)
        {
            if( $role->can($permission) ){
                $can = true;
            }
        }

        return $can;
    }

    /**
     * Check if person has at least one of the given permissions
     * @param array $permissions
     * @return bool
     */
    public function canAtLeast(array $permissions) : bool
    {
        $can = false;

        foreach ($this->roles as $role)
        {
            if( $role->canAtleast($permissions) ){
                $can = true;
            }
        }

      return $can;
    }


    /**
     * Handles dynamic calls to has and can
     * @param $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, $arguments = [])
    {
        if( starts_with($method, 'has') && $method !== 'has' )
        {
            $role = substr($method, 3);
            return $this->has($role);
        }

        if( starts_with($method, 'can') && $method !== 'can' )
        {
            $permission = substr($method, 3);

            return $this->can($permission);
        }

        return parent::__call($method, $arguments);
    }

}