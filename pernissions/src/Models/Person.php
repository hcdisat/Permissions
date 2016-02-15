<?php namespace ITeam\Permissions\Models;

use ITeam\Permissions\Traits\PermissableTrait;
use ITeam\Permissions\Traits\RoleTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Person extends Authenticatable implements Transformable
{
    use PermissableTrait, RoleTrait, TransformableTrait;

    /**
     * The attributes that are fillable via mass assignment.
     * @var array
     */
    protected $fillable = [
        'first_name',
        'las_name',
        'person_type_id'
    ];
}
