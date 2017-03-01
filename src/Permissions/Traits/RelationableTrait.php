<?php namespace CVA\Permissions\Traits;


use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait RelationableTrait
{
    /**
     * @var string represent the main user entity class
     */
    protected $userEntityClass;

    /**
     * @var string represent the main group entity class
     */
    protected  $groupEntityClass;

    protected function init()
    {
        $this->userEntityClass = config('permissions.user.class');
        $this->groupEntityClass = config('permissions.group.class');
    }


    /**
     * return People morphed by Role
     * @return MorphToMany
     */
    public function userEntity() : MorphToMany
    {
        return $this->morphedByMany($this->userEntityClass, 'roleable');
    }

    /**
     * Networks morphed by this role
     * @return MorphToMany
     */
    public function groupEntity() : MorphToMany
    {
        return $this->morphedByMany($this->groupEntityClass, 'rolable');
    }

    /**
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters = [])
    {
        // call the user entity relationship
        if( $method == config('permissions.user.name') ) {
            return $this->userEntity();
        }

        // call the group entity relationship
        if( $method == config('permissions.group.name') ) {
            return $this->groupEntity();
        }

        // Handles dynamic calls to can
        if( starts_with($method, 'can') && $method !== 'can' )
        {
            $permission = substr($method, 3);

            return $this->hasRole($permission);
        }
        
        // handles dynamic calls to has
        $hasPermission = 'hasPermission';
        if( starts_with($method, $hasPermission) && $method !== $hasPermission )
        {
            $role = substr($method, strlen($hasPermission));
            return $this->hasPermission($role);
        }

        return parent::__call($method, $parameters);
    }

}