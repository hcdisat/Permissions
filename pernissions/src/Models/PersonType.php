<?php namespace ITeam\Permissions\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonType extends ModelBase
{

    /**
     * The attributes that are not fillable via mass assignment.
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * PersonType has many People
     * @return HasMany
     */
    public function people() : HasMany
    {
        return $this->hasMany(Person::class);
    }
}
