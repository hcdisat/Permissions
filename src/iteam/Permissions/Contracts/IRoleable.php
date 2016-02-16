<?php namespace ITeam\Permissions\Contracts;


interface IRoleable
{

    public function getRoles();

    public function has($slug);

    public function assignRole($roleId) : bool;

    public function addRoles(array $roles) : int;

    public function revokeRole($roleId = '') : int;

    public function syncRoles(array $roles) : array;

    public function revokeAllRoles() : int;

    public function getPermissions() : array;

    public function can($permission, $arguments = []);

    public function canAtLeast(array $permissions) : bool;

}