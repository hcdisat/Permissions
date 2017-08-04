<?php namespace HcDisat\Permissions\Contracts;


interface IPermissable
{

    public function getPermissions() : array;

    public function assignPermission($roleId) : bool;

    public function assignPermissions(array $roles) : int;

    public function revokePermission($roleId = '') : int;

    public function revokeAllPermissions() : int;

    public function syncPermissions(array $roles) : array;

    public function hasPermission($slug);

    public function hasAtLeast(array $permissions) : bool;
}