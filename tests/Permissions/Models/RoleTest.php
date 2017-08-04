<?php

use CVA\Permissions\Models\Permission;
use CVA\Permissions\Models\Role;
use Tests\TestCase;

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


    public function testIfRelHasGivenPermission()
    {
        $permissions = factory(Permission::class, 5)->create()->each(function($p){
            $this->role->permissions()->attach($p);
        });

        $result = $permissions->pluck('slug')->toArray();

        $this->assertTrue($this->role->hasPermission($permissions->first()->slug));

        $this->assertTrue($this->role->hasPermission($result));

        $this->assertFalse($this->role->hasPermission(array_merge($result,['foo'])));
    }

    public function testCanAtLeast()
    {
        $permissions = factory(Permission::class, 5)->create()->each(function($p){
            $this->role->permissions()->attach($p);
        });

        $result = $permissions->pluck('slug')->toArray();


        $this->assertTrue($this->role->hasAtLeast(array_except($result, array_pop($result))));
    }


    public function testRevokePermissions()
    {
        $permissions = factory(Permission::class, 5)->create()->each(function($p){
            $this->role->permissions()->attach($p);
        });

        $this->assertEquals(1, $this->role->revokePermission($permissions->first()));

    }

    public function testOtherRemovePermissionsFunctions()
    {
        $permissionsSync = factory(Permission::class, 5)->create()->each(function($p){
            $this->role->permissions()->attach($p);
        });

        $this->assertEquals(empty([]), $this->role->revokeAllPermissions());

        $result = $this->role->syncPermissions($permissionsSync->pluck('id')->toArray());

        $this->assertEquals(5, count($result['attached']));

    }

}
