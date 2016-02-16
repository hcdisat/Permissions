<?php


use ITeam\Permissions\Models\Permission;
use ITeam\Permissions\Models\Role;

class RoleTest extends TestCase
{

    protected $role;

    public function setUp()
    {
        parent::setUp();
        $this->role = factory(Role::class)->create();
    }

    public function testAddPermissions()
    {
        factory(Permission::class, 5)->create()
            ->each(function($p){
                $this->role->assignPermission($p);
            });

        $this->assertTrue($this->role->permissions()->count() > 0);
    }


    public function testGetPermissions()
    {

        foreach (factory(Permission::class, 5)->create() as $permission)
        {
            $this->role->permissions()->attach($permission);
        }

        $this->assertTrue(count($this->role->getPermissions()) > 0);
    }


    public function testIfRolHasGivenPermistion()
    {
        $permissions = factory(Permission::class, 5)->create()->each(function($p){
            $this->role->permissions()->attach($p);
        });

        $result = $permissions->pluck('slug')->toArray();

        $this->assertTrue($this->role->can($permissions->first()->slug));

        $this->assertTrue($this->role->can($result));

        $this->assertFalse($this->role->can(array_merge($result,['foo'])));
    }

    public function testCanAtLeast()
    {
        $permissions = factory(Permission::class, 5)->create()->each(function($p){
            $this->role->permissions()->attach($p);
        });

        $result = $permissions->pluck('slug')->toArray();


        $this->assertTrue($this->role->canAtLeast(array_except($result, array_pop($result))));
    }


    public function testRevokePermissions()
    {
        $permissions = factory(Permission::class, 5)->create()->each(function($p){
            $this->role->permissions()->attach($p);
        });

        $this->assertEquals(1, $this->role->revokePermission($permissions->first()));

    }

    public function testOtherRemovePermitionsFunctions()
    {
        $permissionsSync = factory(Permission::class, 5)->create()->each(function($p){
            $this->role->permissions()->attach($p);
        });

        $this->assertEquals(empty([]), $this->role->revokePermissions());

        $result = $this->role->syncPermissions($permissionsSync->pluck('id')->toArray());

        $this->assertEquals(5, count($result['attached']));

    }

}