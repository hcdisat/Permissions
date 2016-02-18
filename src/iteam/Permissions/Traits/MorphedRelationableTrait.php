<?php namespace ITeam\Permissions\Traits;


use Illuminate\Database\Eloquent\Relations\MorphToMany;
use ITeam\Permissions\Models\Permission;
use ITeam\Permissions\Models\Role;

trait MorphedRelationableTrait
{
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
}