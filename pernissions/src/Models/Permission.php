<?php namespace ITeam\Permissions\Models;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Permission extends ModelBase
{

    /**
     * The attributes that are not fillable via mass assignment. 
     * @var
     */
    protected $guarded = ['id'];


    /**
     * Permisions belongs to many roles
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }

    /**
     * return People morphed by Permission
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function people() : MorphToMany
    {
        return $this->morphedByMany(Person::class, 'permissable');
    }

    public function networks()
    {
        return $this->morphedByMany(Network::class, 'permissable');
    }
}
