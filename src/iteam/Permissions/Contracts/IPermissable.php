<?php namespace ITeam\Permissions\Contracts;


interface IPermissable
{

    public function has($slug);

    public function hasAtLeast(array $permissions) : bool;

    public function getPermissions() : array;

    public function assignPermission($roleId) : bool;

    public function assignPermissions(array $roles) : int;

    public function revokePermission($roleId = '') : int;

    public function syncPermissions(array $roles) : array;

    public function revokeAllPermissions() : int;
}