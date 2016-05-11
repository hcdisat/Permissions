<?php namespace CVA\Permissions\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use CVA\Permissions\Contracts\IRoleable;
use CVA\Permissions\Traits\RelationableTrait;
use CVA\Permissions\Traits\RoleableTrait;

class Permission extends Model implements IRoleable
{
    use RelationableTrait, RoleableTrait;

    /**
     * The attributes that are not fillable via mass assignment. 
     * @var
     */
    protected $guarded = ['id'];


    /**
     * Permissions constructor.
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
