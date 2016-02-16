<?php namespace ITeam\Permissions\Traits;


use ITeam\Permissions\Models\Credential;
use ITeam\Permissions\Models\Network;
use ITeam\Permissions\Models\PersonType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait PermissableTrait
{
    /**
     * a Person has many PersonType
     * @return BelongsTo
     */
    public function personType() : BelongsTo
    {
        return $this->belongsTo(PersonType::class);
    }

    /**
     * a Person has one Credential
     * @return HasOne
     */
    public function credentials() : HasOne
    {
        return $this->hasOne(Credential::class);
    }

    /**
     * Persom has and belongs to many networks
     * @return BelongsToMany
     */
    public function networks() : BelongsToMany
    {
        return $this->belongsToMany(Network::class)
            ->withTimestamps();
    }

    /**
     * all networks' name that belongs to the person
     * @return array
     */
    public function getAllNetworksForPerson() : array
    {
        return $this->networks()
            ->pluck('name')
            ->all();
    }

    #region Accessors
    /**
     * Get the person type
     * @return string
     */
    public function getTypeAttribute()
    {
        return $this->personType->name;
    }

    public function getUsernameAttribute()
    {
        return $this->credentials->username;
    }

    public function getPasswordAttribute()
    {
        return $this->credentials->password;
    }

    #endregion
}