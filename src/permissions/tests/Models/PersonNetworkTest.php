<?php

use ITeam\Permissions\Models\Network;
use ITeam\Permissions\Models\Person;
use ITeam\Permissions\Models\Role;

class PersonNetworkTest extends TestCase
{

    protected $network;

    public function setUp()
    {
        parent::setUp();

        $this->network = factory(Network::class)->create();
    }

    public function testPeopleInNetwork()
    {
        foreach (factory(Person::class, 5)->create() as $person) {
            $this->network->addPerson($person);
        }

        $this->assertTrue($this->network->people()->count() == 5);

    }

    public function testAddManyPeopleIntoANetwork()
    {
        $people = factory(Person::class, 5)->create();

        $this->network->addPeople($people);

        $this->assertTrue($this->network->people()->count() == 5);

        $morePeople = factory(Person::class, 5)->create();

        $this->network->addPeople($morePeople->toArray());
    }

    public function testNetworkAssignRole()
    {
        $role = factory(Role::class)->create();

        $this->network->assignRole($role->id);

        $this->assertTrue($role->slug == $this->network->roles()->first()->slug);
    }

    public function testNetworkHasRole()
    {
        $role = factory(Role::class)->create(['id' => 25]);

        $this->network->roles()->sync([25]);

        $this->assertTrue($this->network->has($role->slug), $role->id);
    }

    public function testListNetworkRoles()
    {

        $roles = factory(Role::class, 5)->create();

        foreach ($roles as $role) {
            $this->network->roles()->attach($role->id);
        }

        $result = $this->network->getRoles();
        $this->assertSameSize($roles, $result);

    }

    public function testsAddVariousRoles()
    {
        $this->assertTrue(empty($this->network->roles));

        $roles = factory(Role::class, 5)->create();

        $result = $this->network->addRoles($roles->pluck('id')->toArray());

        $this->assertTrue($roles->count() == $result);

    }


    public function testRevokeRole()
    {
        $role = factory(Role::class)->create();

        $this->network->assignRole($role->id);

        $this->assertTrue($this->network->roles()->first()->slug == $role->slug);

        $this->network->revokeRole($role->id);

        $this->assertNull($this->network->roles()->first());

    }

    public function testSyncRoles()
    {
        $this->assertTrue(empty($this->network->roles));

        $roles = factory(Role::class, 5)->create();

        $resultAdded = $this->network->syncRoles($roles->pluck('id')->toArray());
        $ressultDeleted = $this->network->syncRoles([]);

        $this->assertTrue($resultAdded['attached'] == $ressultDeleted['detached']);
    }

    public function testRevokeAllRoles()
    {
        $this->assertTrue(empty($this->network->roles));

        $roles = factory(Role::class, 5)->create();

        $resultAdded = $this->network->syncRoles($roles->pluck('id')->toArray());
        $resultDeleted = $this->network->revokeAllRoles();

        $this->assertTrue(count($resultAdded['attached']) == $resultDeleted);
    }
}