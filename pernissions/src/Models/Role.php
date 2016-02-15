<?php namespace ITeam\Permissions\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Role extends ModelBase
{

    /**
     * The attributes that are not fillable via mass assignment.
     * @var
     */
    protected $guarded = ['id'];

    /**
     * Roles can have many permissions
     * @return BelongsToMany
     */
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Permission::class)
            ->withTimestamps();
    }


    /**
     * return People morphed by Role
     * @return MorphToMany
     */
    public function people() : MorphToMany
    {
        return $this->morphedByMany(Person::class, 'roleable');
    }

    /**
     * Networks morphed by this role
     * @return MorphToMany
     */
    public function networks() : MorphToMany
    {
        return $this->morphedByMany(Network::class, 'rolable');
    }

    /**
     * Get slug field asigned to role
     * @return array
     */
    public function getPermissions() : array
    {
        return $this->permissions
            ->pluck('slug')->all();
    }

    /**
     * checks if the role has a given permission
     * @param $permission
     * @return bool
     */
    public function can($permission) : bool
    {
        // get permissions
        $permissions = $this->getPermissions();

        // check if the parameter is an array
        if( is_array($permission) )
        {
            // Count the interection
            $interectionCount = array_intersect($permissions, $permission);
            return
                // if equals then ew grant access
                count($permission) == count($interectionCount);
        }

        // if not check if the permission is in the list
        return in_array($permission, $permissions);
    }

    /**
     * Checks if the role has at least one of the given permissions
     * @param array $permission
     * @return bool
     */
    public function canAtLeast(array $permission) : bool
    {
        if( empty($permission )) return false;

        $permissions = $this->getPermissions();

        $intersection = array_intersect($permissions, $permission);

        return count($intersection) > 0;
    }

    /**
     * Attachs a single permission to the role
     * @param $permissionId
     * @return bool
     */
    public function assignPermission($permissionId) : bool
    {

        if( !$this->permissions->contains($permissionId) )
        {
            $this->permissions()->attach($permissionId);
            return true;
        }

        return false;
    }

    /**
     * Revokes a permition
     * @param string $permissionId
     * @return int the number of removed permissions
     */
    public function revokePermission($permissionId = '') : int
    {
        return $this->permissions()->detach($permissionId);
    }

    /**
     * Revoke all permitions
     * @return int the number of removed permissions
     */
    public function revokePermissions() : int
    {
        return $this->permissions()->detach();
    }


    /**
     *  Syncs the given permisssion
     * @param array $permissions
     * @return array of the updated, attached or detached items
     */
    public function syncPermissions(array $permissions) : array
    {
        if( empty($permissions) ) return [];

        return $this->permissions()->sync($permissions);
    }

}
