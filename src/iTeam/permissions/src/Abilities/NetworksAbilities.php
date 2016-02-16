<?php namespace ITeam\Permissions\Abilities;


use ITeam\Permissions\Models\Person;

class NetworksAbilities
{


    /**
     * verify if a person is in a network
     * @param Person $person
     * @param $networks
     * @return bool
     */
    public function canNetworkSee(Person $person, $networks) : bool
    {
        $personNetworks = $person->getAllNetworksForPerson();

        if( is_array($networks) ){
            $intersections = array_intersect($personNetworks, $networks);

            return ( count($intersections) == count($networks) );
        }

        return in_array($networks, $personNetworks);
    }


    // TODO:: Specific Abilities
}