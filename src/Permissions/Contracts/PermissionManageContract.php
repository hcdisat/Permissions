<?php namespace HcDisat\Permissions\Contracts;


interface PermissionManageContract
{

    /*
     * Roles
     */
    public function assignRole($roleId) : bool;

    public function assignRoles(array $roles) : int;

    public function revokeRole($roleId = '') : int;

    public function revokeAllRoles() : int;

    public function syncRoles(array $roles) : array;


    /*
     * Permissions
     */
    public function assignPermission($roleId) : bool;

    public function assignPermissions(array $roles) : int;

    public function revokePermission($roleId = '') : int;

    public function revokeAllPermissions() : int;

    public function syncPermissions(array $roles) : array;
}