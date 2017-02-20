<?php namespace CVA\Permissions\Models;

use CVA\Billing\Traits\ByNameCriteria;
use CVA\Commerce\Services\PlanBuilder\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use CVA\Permissions\Contracts\IPermissable;
use CVA\Permissions\Traits\PermissableTrait;
use CVA\Permissions\Traits\RelationableTrait;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * CVA\Permissions\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\CVA\Permissions\Models\Permission[] $permissions
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Role whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\CVA\Permissions\Models\Role whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model implements IPermissable
{
    use PermissableTrait, RelationableTrait, ByNameCriteria; 

    const Position = 'Position';

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

    /**
     * Has many Roles Polymorphic
     * @return MorphToMany
     */
    public function children() : MorphToMany
    {
        return $this->morphToMany(Role::class, 'roleable');
    }
}
