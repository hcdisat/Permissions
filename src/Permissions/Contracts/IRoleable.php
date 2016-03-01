<?php namespace CVA\Permissions\Contracts;


interface IRoleable
{

    public function getRoles();

    public function assignRole($roleId) : bool;

    public function addRoles(array $roles) : int;

    public function revokeRole($roleId = '') : int;

    public function syncRoles(array $roles) : array;

    public function revokeAllRoles() : int;

    public function can($permission, $arguments = []);

    public function canAtLeast(array $permissions) : bool;

}