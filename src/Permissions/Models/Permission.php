<?php namespace HcDisat\Permissions\Models;

use HcDisat\Commons\Traits\ByNameCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use HcDisat\Permissions\Contracts\IRoleable;
use HcDisat\Permissions\Traits\RelationableTrait;
use HcDisat\Permissions\Traits\RoleableTrait;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * HcDisat\Permissions\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\HcDisat\Permissions\Models\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Permission whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Permission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\HcDisat\Permissions\Models\Permission whereUpdatedAt($value)
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
