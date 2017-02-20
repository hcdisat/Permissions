<?php namespace CVA\Permissions\Models;


use CVA\Billing\Traits\ByNameCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use CVA\Permissions\Contracts\IRoleable;
use CVA\Permissions\Traits\RelationableTrait;
use CVA\Permissions\Traits\RoleableTrait;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * CVA\Permissions\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\CVA\Permissions\Models\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Permission whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Permission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends Model implements IRoleable
{
    use RelationableTrait, RoleableTrait, ByNameCriteria;

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

    /**
     * Has many Permissions Polymorphic
     * @return MorphToMany
     */
    public function children() : MorphToMany
    {
        return $this->morphToMany(Permission::class, 'permissable');
    }
}
