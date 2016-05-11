<?php

use App\Models\Credential;
use App\Models\PersonType;
use App\Models\Person;
use CVA\Permissions\Models\Role;

class PersonTest extends TestCase
{

    protected $person;

    public function setUp()
    {
        parent::setUp();
        $this->person = factory(config('permissions.user.class'))->create();
    }

    public function testCreateNewPersonRecord()
    {
        $this->assertInstanceOf(config('permissions.user.class'), $this->person);
        $this->assertNotNull($this->person->id);
    }

    public function testPersonHasType()
    {
        $type = factory(PersonType::class)->create();
        $type->people()->save(factory(config('permissions.user.class'))->make());

        $this->assertTrue($type->name == $type->people()->first()->type);
    }

    public function testPersonHasCredentials()
    {
        $this->person->credentials()
            ->save(factory(Credential::class)->make());

        $this->assertTrue($this->person->username == $this->person->credentials->username);
        $this->assertFalse(empty($this->person->username), $this->person->username);
        $this->assertFalse(empty($this->person->password), $this->person->password);
    }

    public function testPersonAssignRole()
    {
        $role = factory(Role::class)->create();

        $this->person->assignRole($role->id);

        $this->assertTrue($role->slug == $this->person->roles()->first()->slug);
    }


    public function testPersonHasRole()
    {
        $role = factory(Role::class)->create(['id' => 25]);

        $this->person->roles()->sync([25]);

        $this->assertTrue($this->person->can($role->slug), $role->id);
    }


    public function testListPersonRoles()
    {

        $roles = factory(Role::class, 5)->create();

        foreach ($roles as $role) {
            $this->person->roles()->attach($role->id);
        }

        $result = $this->person->getRoles();
        $this->assertSameSize($roles, $result);

    }

    public function testsAddVariousRoles()
    {
        $this->assertTrue(empty($this->person->roles));

        $roles = factory(Role::class, 5)->create();

        $result = $this->person->addRoles($roles->pluck('id')->toArray());

        $this->assertTrue($roles->count() == $result);

    }


    public function testRevokeRole()
    {
        $role = factory(Role::class)->create();

        $this->person->assignRole($role->id);

        $this->assertTrue($this->person->roles()->first()->slug == $role->slug);

        $this->person->revokeRole($role->id);

        $this->assertNull($this->person->roles()->first());

    }

    public function testSyncRoles()
    {
        $this->assertTrue(empty($this->person->roles));

        $roles = factory(Role::class, 5)->create();

        $resultAdded = $this->person->syncRoles($roles->pluck('id')->toArray());
        $resultDeleted = $this->person->syncRoles([]);

        $this->assertTrue($resultAdded['attached'] == $resultDeleted['detached']);
    }

    public function testRevokeAllRoles()
    {
        $this->assertTrue(empty($this->person->roles));

        $roles = factory(Role::class, 5)->create();

        $resultAdded = $this->person->syncRoles($roles->pluck('id')->toArray());
        $resultDeleted = $this->person->revokeAllRoles();

        $this->assertTrue(count($resultAdded['attached']) == $resultDeleted);
    }
}
