<?php namespace CVA\Permissions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use CVA\Permissions\Contracts\IPermissable;
use CVA\Permissions\Traits\PermissableTrait;
use CVA\Permissions\Traits\RelationableTrait;

class Role extends Model implements IPermissable
{
    use  PermissableTrait, RelationableTrait;


    /**
     * The attributes that are not fillable via mass assignment.
     * @var
     */
    protected $guarded = ['id'];

    /**
     * Role constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->init();
    }

    /**
     * Has many Permissions Polymorphic
     * @return BelongsToMany
     */
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Permission::class)
            ->withTimestamps();
    }
}
