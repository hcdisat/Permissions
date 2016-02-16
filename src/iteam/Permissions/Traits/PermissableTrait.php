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
     * all networks' name that belongs to the person
     * @return array
     */
    public function getAllNetworksForPerson() : array
    {
        return $this->networks()
            ->pluck('name')
            ->all();
    }
}