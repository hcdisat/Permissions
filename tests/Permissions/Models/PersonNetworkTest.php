<?php

use CVA\Permissions\Models\Role;

class PersonNetworkTest extends TestCase
{

    protected $network;

    public function setUp()
    {
        parent::setUp();


        $this->network = factory(config('permissions.group.class'))->create();
    }

    public function testPeopleInNetwork()
    {
        foreach (factory(config('permissions.user.class'), 5)->create() as $person) {
            $this->network->addPerson($person);
        }

        $this->assertTrue($this->network->people()->count() == 5);

    }

    public function testAddManyPeopleIntoANetwork()
    {
        $people = factory(config('permissions.user.class'), 5)->create();

        $this->network->addPeople($people);

        $this->assertTrue($this->network->people()->count() == 5);

        $morePeople = factory(config('permissions.user.class'), 5)->create();

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

        $this->assertTrue($this->network->can($role->slug), $role->id);
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
        $this->assertTrue($this->network->roles->isEmpty());

        $roles = factory(Role::class, 5)->create();

        $result = $this->network->assignRoles($roles->pluck('id')->toArray());

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
        $this->assertTrue($this->network->roles->isEmpty());

        $roles = factory(Role::class, 5)->create();

        $resultAdded = $this->network->syncRoles($roles->pluck('id')->toArray());
        $resultDeleted = $this->network->syncRoles([]);

        $this->assertTrue($resultAdded['attached'] == $resultDeleted['detached']);
    }

    public function testRevokeAllRoles()
    {
        $this->assertTrue($this->network->roles->isEmpty());

        $roles = factory(Role::class, 5)->create();

        $resultAdded = $this->network->syncRoles($roles->pluck('id')->toArray());
        $resultDeleted = $this->network->revokeAllRoles();

        $this->assertTrue(count($resultAdded['attached']) == $resultDeleted);
    }
}
