<?php namespace CVA\Permissions\Contracts;


interface IRoleable
{

    public function getRoles();

    public function assignRole($roleId) : bool;

    public function assignRoles(array $roles) : int;

    public function revokeRole($roleId = '') : int;

    public function revokeAllRoles() : int;

    public function syncRoles(array $roles) : array;

    public function can($permission, $arguments = []);

    public function hasRole($permission);

    public function canAtLeast(array $permissions) : bool;

}