<?php namespace ITeam\Permissions\Models;

use ITeam\Permissions\Traits\RoleTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Network extends ModelBase
{
    use RoleTrait;

    /**
     * The attributes that are not fillable via mass assignment.
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * get People in this network
     * @return BelongsToMany
     */
    public function people() : BelongsToMany
    {
        return $this->belongsToMany(Person::class)
            ->withTimestamps();
    }


    /**
     * Add a person to this network
     * @param $person
     * @return bool
     */
    public function addPerson($person) : bool
    {
        if( is_numeric($person) || ($person instanceof Person) )
        {
            $this->people()->attach($person);
            return true;
        }

        return false;
    }

    /**
     * Add many people to the netwok
     * @param Collection|array $people
     * @return int number of people added
     */
    public function addPeople($people) : int
    {
        $counter = 0;
        if( is_array($people) )
        {
            foreach ($people as $person) {
                if( $this->addPerson($person) ) $counter++;
            }
        }

        if( $people instanceof Collection )
        {
            foreach ($people as $person) {
                if( $this->addPerson($person) ) $counter++;
            }
        }

        return $counter;
    }
}
