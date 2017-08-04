<?php namespace HcDisat\Permissions\Traits;


use Illuminate\Database\Eloquent\Relations\MorphToMany;
use HcDisat\Permissions\Models\Permission;
use HcDisat\Permissions\Models\Role;

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