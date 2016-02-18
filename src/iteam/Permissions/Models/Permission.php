<?php namespace ITeam\Permissions\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use ITeam\Permissions\Contracts\IRoleable;
use ITeam\Permissions\Traits\RelationableTrait;
use ITeam\Permissions\Traits\RoleableTrait;

class Permission extends Model implements IRoleable
{
    use RelationableTrait, RoleableTrait;

    /**
     * The attributes that are not fillable via mass assignment. 
     * @var
     */
    protected $guarded = ['id'];


    /**
     * Permission constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->init();
    }

    /**
     * Permisions belongs to many roles
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }
}
