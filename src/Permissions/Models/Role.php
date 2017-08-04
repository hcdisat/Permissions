<?php namespace HcDisat\Permissions\Models;

use HcDisat\Commons\Traits\ByNameCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use HcDisat\Permissions\Contracts\IPermissable;
use HcDisat\Permissions\Traits\PermissableTrait;
use HcDisat\Permissions\Traits\RelationableTrait;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * HcDisat\Permissions\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\HcDisat\Permissions\Models\Permission[] $permissions
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Role whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Role whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model implements IPermissable
{
    use PermissableTrait, RelationableTrait, ByNameCriteria; 

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
